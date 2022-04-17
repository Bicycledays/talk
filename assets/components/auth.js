$(document).ready(auth);

const ticket = 'talk_token'

function auth()
{
    $('#auth_submit_button').click(function (event) {
        let username = $('#username').val();
        let password = $('#password').val();
        $.ajax({
            type: "POST",
            accept: "application/json",
            contentType: "application/json",
            url: '/api/auth/sign-in',
            data: JSON.stringify({
                username: username,
                password: password
            }),
            dataType: "json",
            success: saveToken
        })
    })
}

function saveToken(data)
{
    window.localStorage.setItem(ticket, "Bearer " + data.token)
}

function token()
{
    window.localStorage.getItem(ticket)
}