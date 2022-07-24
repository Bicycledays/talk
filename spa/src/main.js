import "bootstrap/dist/css/bootstrap.css"
import {createApp} from "vue";
import {createApiClient} from "./api/client";
import App from "./App.vue";
import router from "./router";

const app = createApp(App);

app.config.globalProperties.$api = createApiClient();
app.use(router);
app.mount("#app");

import "bootstrap/dist/js/bootstrap"
