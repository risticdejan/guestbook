const state = {
    refresh: false,
    loadingApp: false,
    loading: false
};

const mutations = {
    setRefresh: (state, payload) => {
        state.refresh = payload;
    },
    setLoadingApp: (state, payload) => {
        state.loadingApp = payload;
    },
    setLoading: (state, payload) => {
        state.loading = payload;
    }
};

const actions = null;

const getters = {
    refresh: state => state.refresh,
    loadingApp: state => state.loadingApp,
    loading: state => state.loading
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
