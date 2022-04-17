$(document).ready(talkers);

const url = '/api/all-talkers'

function talkers()
{
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

function insertTalkers(data)
{
    $.each(data.result, function(i, user){
        $('#talkers_listing').append("<tr><td>" + user.username + "</td></tr>");
    })
}