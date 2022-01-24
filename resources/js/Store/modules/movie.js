import axios from "axios";

const state = () => ({
    movie: null,
    show: false,
    update_data: {
        route: null,
        movie_id: null,
    },
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
    },
};

const actions = {
    async selectMovie({ commit }, id) {
        const movie = await axios.get(route("movies.show", id)).then(
            (response) => response.data
        );

        commit("SET_MOVIE", movie);
    },
    showMovie({ commit }) {
        commit("SET_SHOW", true);
    },
    hideMovie({ commit }) {
        commit("SET_SHOW", false);
        commit("SET_MOVIE", null);
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
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
