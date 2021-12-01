const state = () => ({
    movie: null,
});

const getters = {
    getSelectedMovie(state) {
        return state.movie;
    },
};

const actions = {
    selectMovie({ commit }, movie) {
        commit("SET_MOVIE", movie);
    },
};

const mutations = {
    SET_MOVIE(state, movie) {
        state.movie = movie;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
