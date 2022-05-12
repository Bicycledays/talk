import {getToken} from './token'

$(document).ready(talk);

const url = '/api/talk/'

function talk() {
    let searchParams = new URLSearchParams(window.location.search)
    let id = searchParams.get('id')
    $.ajax({
        type: "GET",
        accept: "application/json",
        headers: {
            "Authorization": getToken()
        },
        contentType: "application/json",
        url: url + id,
        dataType: "json",
        success: fill
    })
}

function fill(data) {
    if (!data.success) {
        alert(data.message);
    }
    $('#talk').append(data.result.view)
}