import {getToken} from './token'

$(document).ready(profile);

const url = '/api/profile'

function profile() {
    let searchParams = new URLSearchParams(window.location.search)
    let id = searchParams.get('id')
    let attr = id ? '/' + id : ''
    $.ajax({
        type: "GET",
        accept: "application/json",
        headers: {
            "Authorization": getToken()
        },
        contentType: "application/json",
        url: url + attr,
        dataType: "json",
        success: fill
    })
}

function fill(data) {
    if (!data.success) {
        alert(data.message);
    }
    $('#profile').append(data.result.view)
}