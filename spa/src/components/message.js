class Message {
    constructor(json) {
        this.author = json.author
        this.text = json.text
        this.talkId = json.talkId ?? null
    }

    html() {
        return  '<a href="#" class="list-group-item list-group-item-action">\n' +
            `<p class="mb-1">${this.text}</p>\n` +
            `<small class="text-muted">${this.author.username}</small>\n` +
            '</a>'
    }
}