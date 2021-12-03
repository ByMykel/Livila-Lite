<template>
    <app-layout title="Liked">
        <div
            ref="movies"
            class="flex-1 w-full h-screen overflow-auto bg-black-400 no-scrollbar"
        >
            <div class="w-full px-5 pt-3">
                <h3 class="text-2xl font-bold text-white">Liked movies</h3>
            </div>
            <div
                class="grid w-full gap-0 p-4 px-5"
                style="
                    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                    grid-template-rows: repeat(auto-fill, minmax(95px, 1fr));
                "
            >
                <Movie
                    v-for="movie in movies_data"
                    :key="movie.id"
                    :movie="movie"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Movie from "@/Components/Movie.vue";

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

    methods: {
        getMoreMovies() {
            const { movies } = this.$refs;

            let bottomOfWindow =
                movies.scrollHeight === movies.scrollTop + window.innerHeight;

            if (bottomOfWindow) {
                axios.get(route("liked.page", {page: ++this.page})).then((response) => {
                    if (!response.data.length) {
                        window.removeEventListener("scroll", this.getMoreMovies, true);
                        return;
                    }

                    this.movies_data.push(...response.data);
                });
            }
        },
    },

    mounted() {
        window.addEventListener("scroll", this.getMoreMovies, true);
    },
});
</script>
