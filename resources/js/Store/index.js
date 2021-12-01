import { createStore } from "vuex";
import movie from "./modules/movie";

const debug = process.env.NODE_ENV !== "production";

export default createStore({
    modules: {
        movie,
    },
    strict: debug,
});
