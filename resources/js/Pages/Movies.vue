<template>
    <app-layout title="Movies">
        <div
            ref="movies"
            class="flex-1 w-full h-screen overflow-auto bg-black-400"
        >
            <div
                class="grid w-full gap-1 p-4 px-5 mx-auto movies-grid-small md:movies-grid max-w-[120rem]"
            >
                <Movie
                    v-for="movie in movies_data"
                    :key="movie.id"
                    :movie="movie"
                />
            </div>
            <div class="flex justify-center my-2" v-if="loading">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="24"
                    height="24"
                    class="fill-current text-black-200 animate-spin"
                >
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z"></path>
                </svg>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Movie from "@/Components/Movie.vue";
import { mapGetters } from "vuex";

export default defineComponent({
    components: {
        AppLayout,
        Movie,
    },

    props: {
        title: String,
        movies: Object,
    },

    data() {
        return {
            movies_data: this.movies,
            page: 1,
            loading: false,
        };
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie", "isShowing"]),
    },

    watch: {
        movies() {
            this.movies_data.map((movie) => {
                if (movie.id === this.getSelectedMovie?.id) {
                    Object.assign(movie, this.getSelectedMovie);
                }
            });
        },
    },

    methods: {
        getMoreMovies() {
            const { movies } = this.$refs;

            let bottomOfWindow =
                movies.scrollHeight < movies.scrollTop + window.innerHeight + 200;

            if (bottomOfWindow) {
                if (this.loading) return;

                this.loading = true;

                axios
                    .get(route("movies.page", ++this.page))
                    .then((response) => {
                        if (!response.data.results.length) {
                            window.removeEventListener(
                                "scroll",
                                this.getMoreMovies,
                                true
                            );
                            this.loading = false;
                            return;
                        }

                        this.loading = false;
                        this.movies_data.push(...response.data.results);
                    });
            }
        },
    },

    mounted() {
        window.addEventListener("scroll", this.getMoreMovies, true);
    },
});
</script>