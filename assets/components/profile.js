$(document).ready(profile);

const url = '/api/profile/'

function profile() {
    let searchParams = new URLSearchParams(window.location.search)
    let id = searchParams.get('id')
    $.ajax({
        type: "GET",
        accept: "application/json",
        headers: {"Authorization": localStorage.getItem('talk_token')},
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
    $('#profile').append(data.result.view)
}