$(document).ready(talkers);

const url = '/api/users'

function talkers() {
    $.ajax({
        type: "GET",
        accept: "application/json",
        headers: {"Authorization": localStorage.getItem('talk_token')},
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
