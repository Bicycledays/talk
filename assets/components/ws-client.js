import {token} from "./token";

const url = "ws://localhost:8888/sockets/talk"

export class WsClient {
    constructor() {
        this.socket = new WebSocket(url);
        this.socket.onopen = function() {this.socket.send(token())}
        this.socket.onclose = function(event) {
            // if (event.wasClean) {
            // } else {
            // }
        };

        this.socket.onmessage = function(event) {
            console.log(event.data)
            let message = new Message(event.data)
            $('#talk_' + message.talkId).append(message.html())
        };

        this.socket.onerror = function(error) {
            // alert("Ошибка " + error.message);
        };
    }

    sendMessage(text, talkId) {
        let message = new Message({
            text: text,
            talkId: talkId
        })

        this.socket.send(JSON.stringify(message))
    }
}
