import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/auth";
import layout from "./modules/layout";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        layout
    }
});
