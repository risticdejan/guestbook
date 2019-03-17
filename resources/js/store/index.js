import Vue from "vue";
import Vuex from "vuex";
import auth from "./modules/auth";
import layout from "./modules/layout";
import entry from "./modules/entry";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        layout,
        entry
    }
});
