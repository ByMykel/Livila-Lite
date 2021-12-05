<template>
    <app-layout title="Movies">
        <div
            ref="movies"
            class="flex-1 w-full h-screen overflow-auto bg-black-400 no-scrollbar"
        >
            <div class="w-full px-5 pt-3">
                <h3 class="text-2xl font-bold text-white">Movies</h3>
            </div>
            <div
                class="grid w-full gap-0 p-4 px-5 movies-grid-small md:movies-grid"
            >
                <Movie v-for="movie in movies_data" :key="movie.id" :movie="movie" />
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
        };
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie"]),
        
    },

    watch: {
        movies() {
            this.movies_data.map(movie => {
                if (movie.id === this.getSelectedMovie.id) {
                    Object.assign(movie, this.getSelectedMovie);
                }
            })
        }
    },

    methods: {
        getMoreMovies() {
            const { movies } = this.$refs;
            
            let bottomOfWindow =
                movies.scrollHeight === movies.scrollTop + window.innerHeight;

            if (bottomOfWindow) {
                axios
                    .get(route("movies.page", ++this.page))
                    .then((response) =>
                        this.movies_data.push(...response.data.results)
                    );
            }
        },
    },

    mounted() {
        window.addEventListener("scroll", this.getMoreMovies, true);
    },
});
</script>