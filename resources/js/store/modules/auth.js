import router from "../../router";

const state = {
    authUser: null,
    isLogged: false,
    isEmailVerified: false,
    token: null,
    error: null
};

const mutations = {
    setRefresh: (state, payload) => {
        state.refresh = payload;
    },
    setLoadingApp: (state, payload) => {
        state.loadingApp = payload;
    },
    setAuthUser: (state, payload) => {
        state.authUser = payload;
    },
    clearAuthUser: state => {
        state.authUser = null;
    },
    setToken: (state, payload) => {
        state.token = payload;
    },
    clearToken: state => {
        localStorage.removeItem("token");
        state.token = null;
    },
    setError: (state, payload) => {
        let error =
            typeof payload === "object"
                ? Object.values(payload).map(item => item[0])
                : [payload];
        state.error = error;
    },
    clearError: state => {
        state.error = null;
    },
    setIsLogged: (state, payload) => {
        state.isLogged = payload;
    }
};

const actions = {
    signin: ({ commit }, payload) => {
        const url = base_url + "api/auth/signin";
        let config = {
            headers: {
                Accept: "application/json"
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .post(url, payload, config)
                .then(res => {
                    const user = res.data.user;
                    const token = res.data.token;

                    commit("setAuthUser", user);
                    commit("setToken", token);

                    localStorage.setItem("token", token);

                    if (user.email_verified_at) {
                        router.push("/");
                    } else {
                        router.push("/email/verification");
                    }

                    resolve(res);
                })
                .catch(err => {
                    if (err.response) {
                        const error = err.response.data.error;
                        commit("setError", error);
                    }
                    reject(err);
                });
        });
    },
    signup: ({ commit }, payload) => {
        const url = base_url + "api/auth/signup";
        let config = {
            headers: {
                Accept: "application/json"
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .post(url, payload, config)
                .then(res => {
                    resolve(res);

                    const user = res.data.user;
                    const token = res.data.token;

                    commit("setAuthUser", user);
                    commit("setToken", token);

                    localStorage.setItem("token", token);

                    if (user.email_verified_at) {
                        router.push("/");
                    } else {
                        router.push("/email/verification");
                    }

                    resolve(res);
                })
                .catch(err => {
                    const error = err.response.data.error;
                    commit("setError", error);

                    reject(err);
                });
        });
    },
    signout: ({ commit, state }) => {
        const url = base_url + "api/auth/signout";
        let config = {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + state.token
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .post(url, null, config)
                .then(res => {
                    commit("clearAuthUser");
                    commit("clearToken");

                    resolve(res);
                })
                .catch(err => {
                    commit("clearAuthUser");
                    commit("clearToken");

                    const error = err.response.data.error;
                    commit("setError", error);

                    reject(err);
                });
        });
    },
    getAuthUser: ({ commit }) => {
        const token = localStorage.getItem("token");
        const url = base_url + "api/auth/user";
        let config = {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .post(url, null, config)
                .then(res => {
                    const user = res.data.user;

                    commit("setAuthUser", user);
                    commit("setToken", token);

                    if (!user.email_verified_at) {
                        router.push("/email/verification");
                    }

                    resolve(res);
                })
                .catch(err => {
                    commit("clearAuthUser");
                    commit("clearToken");

                    reject(err);
                });
        });
    },

    verificationResend: ({ commit }, payload) => {
        const token = localStorage.getItem("token");
        const url = base_url + "/email/resend";
        let config = {
            headers: {
                Accept: "application/json",
                Authorization: "Bearer " + token
            }
        };
        return new Promise((resolve, reject) => {
            axios
                .get(url, config)
                .then(res => {
                    commit("setAuthUser", user);
                    commit("setToken", token);

                    resolve(res);
                })
                .catch(err => {
                    commit("clearAuthUser");
                    commit("clearToken");

                    reject(err);
                });
        });
    }
};

const getters = {
    authUser: state => state.authUser,
    token: state => state.token,
    error: state => state.error,
    isLogged: state => (state.authUser ? true : false),
    isEmailVerified: state =>
        state.authUser && state.authUser.email_verified_at ? true : false
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
