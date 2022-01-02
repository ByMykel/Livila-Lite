const state = () => ({
    movie: null,
    show: false,
    update_data: {
        route: null,
        movie_id: null
    }
});

const getters = {
    isShowing(state) {
        return state.show;
    },
    getSelectedMovie(state) {
        return state.movie;
    },
    getUpdateData(state) {
        return state.update_data;
    }
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
    updateData({ commit }, data) {
        commit("UPDATE_DATA", data);
    },
};

const mutations = {
    SET_MOVIE(state, movie) {
        state.movie = movie;
    },
    SET_SHOW(state, data) {
        state.show = data;
    },
    UPDATE_DATA(state, data) {
        state.update_data = data;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
