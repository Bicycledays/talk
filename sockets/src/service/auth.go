package service

import (
	"github.com/golang-jwt/jwt"
)

type Auth struct {
	key string
}

func (a *Auth) SetKey(key string) {
	a.key = key
}

func NewAuth(key string) Auth {
	return Auth{key: key}
}

type Claims struct {
	jwt.StandardClaims
	Username string   `json:"username"`
	Roles    []string `json:"roles"`
}

////CheckToken возвращает идентификтаор пользователя
//func (a *Auth) CheckToken(tokenString string) (int, error) {
//	content, err := ioutil.ReadFile("var/jwt/private.pem")
//	if err != nil {
//		log.Fatal(err)
//	}
//	log.Println(string(content))
//	token, err := jwt.ParseWithClaims(
//		tokenString,
//		&Claims{},
//		func(token *jwt.Token) (interface{}, error) {
//			return content, nil
//		},
//	)
//	if err != nil {
//		log.Println(err.Error())
//		return "", err
//	}
//
//	log.Println(token.Raw)
//
//	return "", nil
//}
