const key = 'talk-auth'

export function saveToken(token) {
    // $.cookie(
    //     'talk-auth',
    //     data.token,
    //     {expires: 2, path: '/'}
    // )
    window.localStorage.setItem(key, token)
}

export function getToken() {
    return 'Bearer ' + window.localStorage.getItem(key)
}

export function token() {
    return window.localStorage.getItem(key)
}

export function logOut() {
    // todo remove token
}
