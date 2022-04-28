import {getToken} from './token'

$(document).ready(talkers);

const url = '/api/users'

function talkers() {
    $.ajax({
        type: "GET",
        accept: "application/json",
        headers: {
            // "Authorization": 'Bearer ' + $.cookie('talk-auth')
            "Authorization": getToken()
        },
        contentType: "application/json",
        url: url,
        dataType: "json",
        success: insertTalkers
    })
}

function insertTalkers(data) {
    if (!data.success) {
        alert(data.message);
    }
    $('#talkers_listing').append(data.result.view)
}
