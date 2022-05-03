package main

import (
	"context"
	"github.com/joho/godotenv"
	"log"
	"os"
	"os/signal"
	"syscall"
	"talk-chain/sockets/src/handler"
	"talk-chain/sockets/src/server"
	"talk-chain/sockets/src/service"
)

func init() {
	err := godotenv.Load()
	if err != nil {
		log.Fatalln("dotenv.Load error:", err.Error())
	}
}

func main() {
	s := service.NewService(key())
	h := handler.NewHandler(s)

	srv := new(server.Server)
	go func() {
		if err := srv.Run("8888", h.InitRoutes()); err != nil {
			log.Fatalf("error occurred while running http server: %s", err.Error())
		}
	}()

	quit := make(chan os.Signal, 1)
	signal.Notify(quit, syscall.SIGTERM, syscall.SIGINT)
	<-quit

	if err := srv.Shutdown(context.Background()); err != nil {
		log.Fatalf("error occurred on server shutting down: %s", err.Error())
	}
}

func key() string {
	key, found := os.LookupEnv("JWT_PASSPHRASE")
	if !found {
		log.Fatalln("JWT_PASSPHRASE not found")
	}
	log.Println("JWT_PASSPHRASE", key)
	return key
}
