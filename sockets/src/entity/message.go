package entity

import (
	"encoding/json"
	"log"
)

type Message struct {
	Text   string `json:"text"`
	Talk   int    `json:"talkId"`
	Author Talker `json:"author"`
}

func (m *Message) toJson() []byte {
	js, err := json.Marshal(m)
	if err != nil {
		log.Println("convert message to json error:", err.Error())
		return nil
	}

	return js
}

func (m *Message) Save() {
	err := m.Author.SaveMessage(*m)
	if err != nil {
		log.Printf("save message error: %s", err.Error())
	}
}
