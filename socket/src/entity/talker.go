package entity

import (
	"github.com/gorilla/websocket"
	"talk-chain/sockets/src/service/api"
)

type Talker struct {
	Id         int    `json:"id"`
	Username   string `json:"username"`
	Talks      []int
	Connection *websocket.Conn
	*api.Proxy
}

func (t *Talker) Fill() error {
	return t.CheckToken(t)
}

func (t *Talker) SendMessage(message *Message) error {
	return t.Connection.WriteJSON(message)
}
