package service

import (
	"encoding/json"
	"log"
	"talk-chain/sockets/src/entity"
)

type Talkers map[int]*entity.Talker

type Service struct {
	Auth
	Talks map[int]Talkers
	//Talkers map[int]*entity.Talker
}

func NewService(key string) *Service {
	talks := make(map[int]Talkers)

	return &Service{
		NewAuth(key),
		talks,
		//make(map[int]*entity.Talker),
	}
}

func (s *Service) AddSubscriber(talker *entity.Talker) error {
	// проверяем токен и заполняем поля пользователя
	err := talker.Fill()
	if err != nil {
		return err
	}

	err = s.addTalks(talker)
	if err != nil {
		return err
	}

	return nil
}

//addTalks добавляем или дополняем чаты
func (s *Service) addTalks(talker *entity.Talker) error {
	// получаем идентификаторы
	// всех чатов пользователя
	ids, err := talker.TalksIdentifiers()
	if err != nil {
		return err
	}

	for _, id := range ids {
		talkers, found := s.Talks[id]
		// если чат уже есть в поле
		// то смотрим есть ли у этого чата наш пользователь
		if found {
			_, ok := talkers[talker.Id]
			if !ok {
				talkers[talker.Id] = talker
			}
		} else {
			talkers := make(Talkers)
			talkers[talker.Id] = talker
			s.Talks[id] = talkers
		}
	}

	return nil
}

func (s *Service) RemoveSubscriber(talker *entity.Talker) {
	for _, id := range talker.Talks {
		talkers := s.Talks[id]
		talkers[talker.Id] = nil
	}
}

// NewMessage параллельно рассылаем подключенным пользователям и передаем сообщение в symfony
func (s *Service) NewMessage(js []byte, author *entity.Talker) {
	var message *entity.Message

	err := json.Unmarshal(js, message)
	if err != nil {
		log.Println("unmarshal new message error:", err.Error())
		return
	}

	message.Author = *author

	go s.sendMessage(message) // рассылка подписчикам
	go message.Save()         // сохранение в БД
}

func (s *Service) sendMessage(message *entity.Message) {
	talkers, ok := s.Talks[message.Talk]
	if !ok {
		return
	}

	for _, talker := range talkers {
		err := talker.SendMessage(message)
		if err != nil {
			log.Printf("send message to %s error: %s", talker.Username, err.Error())
		}
	}
}
