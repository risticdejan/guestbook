require("./bootstrap");

window.Vue = require("vue");
import router from "./router/index";
import Vuetify from "vuetify";
import store from "./store";

import colors from "vuetify/es5/util/colors";

Vue.use(Vuetify, {
    iconfont: "mdi",
    theme: {
        primary: colors.orange.darken2,
        secondary: colors.orange.lighten2
    }
});

import App from "./App";

import FormAlert from "./components/shared/FormAlert";
Vue.component("form-alert", FormAlert);

const app = new Vue({
    el: "#app",
    store,
    router,
    render: h => h(App)
});
