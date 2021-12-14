const state = () => ({
    movie: null,
    show: false,
});

const getters = {
    isShowing(state) {
        return state.show;
    },
    getSelectedMovie(state) {
        return state.movie;
    },
};

const actions = {
    selectMovie({ commit }, movie) {
        commit("SET_MOVIE", movie);
    },
    showMovie({ commit }) {
        commit("SET_SHOW", true);
    },
    hideMovie({ commit }) {
        commit("SET_SHOW", false);
    },
};

const mutations = {
    SET_MOVIE(state, movie) {
        state.movie = movie;
    },
    SET_SHOW(state, data) {
        state.show = data;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
