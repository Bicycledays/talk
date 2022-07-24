import axios from "axios";

export function createApiClient() {

    const instance = axios.create({
        baseURL: 'http://talk.local/api',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    instance.interceptors.request.use(function (config) {
        // todo хранение токена
        const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NTg2OTA1NTAsImV4cCI6MTY1ODY5NDE1MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidml0YWx5In0.lIaIhw7jkHMV8MPwBzJqa-lW_SGTbUjt91xTFSpPWgwqZQgPmxC8N2FDXtK1QCRVnJA6RhzLXEmWkYKwphTk0fbi1ffw5k0TpuuMNwYMp_I2Msv08nmhZ6HV1WV_nfVX9GMVIgkdNpyFiDRHlOG4Szv7wzYdGMMBRPM05eLDDxTL697-wq0XR29_5jZ-zRZtyjAwisDWN_a60q38njeCcNPs77ae1tLRZJTBsU-Q0vIYFS4mgDDdNMKv6KckoUJfuLEXpaV8aaw51fsHRJ1w0PgUhDwDA-JHedYI3UQD8YUizwYVFZm0vFEWVgwwfzdHaHSrHCjRUrfp6q7nxNaDnQ"
        config.headers.Authorization = 'Bearer ' + token;
        return config;
    }, function (error) {
        if (error.response) {
            if (error.response.status == 401 &&
                error.response.status == 403
            ) {
                // todo редирект на авторизацию (отдельная функция)
            }
        } else if (error.request) {
            // Запрос был сделан, но ответ не получен
            // `error.request`- это экземпляр XMLHttpRequest в браузере и экземпляр
            // http.ClientRequest в node.js
            console.log(error.request);
        } else {
            // Произошло что-то при настройке запроса, вызвавшее ошибку
            console.log('Error', error.message);
        }
        console.log(error.config);
    });

    return instance
}