socket-run:
	go run .socket/bin/main.go
symfony-run:
	cd symfony && php bin/console ca:cl && symfony serve --no-tls
spa-run:
	cd spa && yarn dev
socket-build:
	go build .socket/bin/main.go
	mv main .socket/bin/
