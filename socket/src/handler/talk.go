package handler

import (
	"github.com/gin-gonic/gin"
	"github.com/gorilla/websocket"
	"log"
	"net/http"
	"talk-chain/sockets/src/entity"
	"talk-chain/sockets/src/service/api"
)

var upgrader = websocket.Upgrader{
	ReadBufferSize:  1024,
	WriteBufferSize: 1024,
	CheckOrigin:     func(r *http.Request) bool { return true },
}

func (h *Handler) talk(c *gin.Context) {
	connection, _ := upgrader.Upgrade(c.Writer, c.Request, nil)
	defer connection.Close()

	mt, message, err := connection.ReadMessage()
	if err != nil || mt == websocket.CloseMessage {
		return
	}

	talker := &entity.Talker{
		Connection: connection,
		Proxy:      &api.Proxy{Token: string(message)},
	}

	err = h.service.AddSubscriber(talker)
	if err != nil {
		log.Println("AddSubscriber error:", err.Error())
		return
	}
	defer h.service.RemoveSubscriber(talker)

	for {
		mt, message, err = connection.ReadMessage()
		if err != nil || mt == websocket.CloseMessage {
			break
		}

		log.Println(string(message))
		h.service.NewMessage(message, talker)
	}
}
