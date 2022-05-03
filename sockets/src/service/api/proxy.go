package api

import (
	"bytes"
	"encoding/json"
	"net/http"
	"strconv"
	"talk-chain/sockets/src/entity"
)

type Route string

const (
	host              = "localhost:8000"
	userId      Route = "/api/user-id"
	talkIds     Route = "/api/talk-ids/"
	saveMessage Route = "/api/save-message"
	getMessages Route = "/api/messages/"
	//counters    Route = "/api/counters"
)

type Proxy struct {
	Token string
}

//sendRequest запрос к апи symfony
func (p *Proxy) sendRequest(request *http.Request) ([]byte, error) {
	client := &http.Client{}
	response, err := client.Do(request)
	if err != nil {
		return nil, err
	}
	defer response.Body.Close()

	return checkApiResponse(response)
}

func (p *Proxy) get(route Route) ([]byte, error) {
	url := host + string(route)

	request, err := http.NewRequest("GET", url, nil)
	if err != nil {
		return nil, err
	}
	request.Header.Set("Authorization", "Bearer "+p.Token)
	request.Header.Set("Content-Type", "application/json")

	return p.sendRequest(request)
}

func (p *Proxy) post(route Route, js []byte) ([]byte, error) {
	url := host + string(route)

	request, err := http.NewRequest("POST", url, bytes.NewBuffer(js))
	if err != nil {
		return nil, err
	}
	request.Header.Set("Authorization", "Bearer "+p.Token)
	request.Header.Set("Content-Type", "application/json")

	return p.sendRequest(request)
}

//CheckToken проверяем токен и заполняем поля пользователя
func (p *Proxy) CheckToken(talker *entity.Talker) error {
	result, err := p.get(userId)
	if err != nil {
		return err
	}

	err = json.Unmarshal(result, talker)
	if err != nil {
		return err
	}

	return nil
}

//TalksIdentifiers получаем идентификаторы всех чатов пользователя
func (p *Proxy) TalksIdentifiers() ([]int, error) {
	var ids []int

	result, err := p.get(talkIds)
	if err != nil {
		return nil, err
	}

	err = json.Unmarshal(result, &ids)
	if err != nil {
		return nil, err
	}

	return ids, nil
}

//SaveMessage сохраняем сообщение в БД
func (p *Proxy) SaveMessage(m entity.Message) error {
	js, err := json.Marshal(m)
	if err != nil {
		return err
	}

	_, err = p.post(saveMessage, js)
	return err
}

//Messages получаем сообщения для пользователя, которые он должен увидеть
func (p *Proxy) Messages(talk int) ([]entity.Message, error) {
	result, err := p.get(getMessages + Route(strconv.Itoa(talk)))
	if err != nil {
		return nil, err
	}

	var messages *[]entity.Message
	err = json.Unmarshal(result, messages)

	return *messages, err
}
