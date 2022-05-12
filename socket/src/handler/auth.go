package handler

import (
	"github.com/gin-gonic/gin"
	"log"
)

func (h *Handler) auth(c *gin.Context) {
	log.Println("auth")
	log.Println(c.GetHeader("Authorization"))
}
