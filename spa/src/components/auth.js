import {saveToken} from './token'

$(document).ready(auth);

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
            success: check
        })
    })
}

function check(data)
{
    saveToken(data.token)
    window.location.href = '/users';
}
