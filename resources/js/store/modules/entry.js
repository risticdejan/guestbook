import router from "../../router";

const state = {
    error: null,
    entries: [],
    entry: null,
    current_page: 1,
    length: 1
};

const mutations = {
    clearEntries: state => {
        state.entries = [];
    },

    clearEntry: state => {
        state.entry = null;
    },
    clearCurrentPage: state => {
        state.current_page = 1;
    },

    clearLength: state => {
        state.length = 1;
    },
    clearError: state => {
        state.error = null;
    },
    setError: (state, payload) => {
        let error =
            typeof payload === "object"
                ? Object.values(payload).map(item => item[0])
                : [payload];
        state.error = error;
    },
    setEntries: (state, payload) => {
        state.entries = payload;
    },

    setEntry: (state, payload) => {
        state.entry = payload;
    },
    setCurrentPage: (state, payload) => {
        state.current_page = payload;
    },
    setLength: (state, payload) => {
        state.length = payload;
    }
};

const actions = {
    getEntries: ({ commit }, page_nb) => {
        const url = base_url + "api/entry?page=" + page_nb;
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(res => {
                    const entries = res.data.entries;
                    const cur_page = res.data.current_page;
                    const length = res.data.length;

                    commit("setEntries", entries);
                    commit("setCurrentPage", cur_page);
                    commit("setLength", length);

                    resolve(res);
                })
                .catch(err => {
                    commit("clearEntries");
                    commit("clearCurrentPage");
                    commit("clearLength");
                    reject(err);
                });
        });
    },
    getEntry: ({ commit }, id) => {
        const url = base_url + "api/entry/" + id;
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(res => {
                    const entry = res.data.entry;

                    commit("setEntry", entry);
                    resolve(res);
                })
                .catch(err => {
                    commit("clearEntry");
                    reject(err);
                });
        });
    },
    create: ({ commit, state }, payload) => {
        const url = base_url + "api/entry";
        let config = {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + payload.token
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .post(url, payload, config)
                .then(res => {
                    router.push("/");

                    resolve(res);
                })
                .catch(err => {
                    const error = err.response.data.error;
                    commit("setError", error);

                    reject(err);
                });
        });
    },
    delete: ({ commit, state }, payload) => {
        const url = base_url + "api/entry/" + payload.id;
        let config = {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + payload.token
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .delete(url, config)
                .then(res => {
                    resolve(res);
                })
                .catch(err => {
                    const error = err.response.data.error;
                    commit("setError", error);

                    reject(err);
                });
        });
    },
    update: ({ commit, state }, payload) => {
        const url = base_url + "api/entry/" + payload.id;
        let config = {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + payload.token
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .put(url, payload, config)
                .then(res => {
                    resolve(res);
                })
                .catch(err => {
                    const error = err.response.data.error;
                    commit("setError", error);

                    reject(err);
                });
        });
    }
};

const getters = {
    error: state => state.error,
    entries: state => state.entries,
    entry: state => state.entry,
    current_page: state => state.current_page,
    length: state => state.length
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
