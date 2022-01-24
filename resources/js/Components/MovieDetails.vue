<template>
    <div class="px-4 text-white md:pt-0 bg-black-400">
        <div class="flex items-center w-full py-3 md:justify-end">
            <button @click="hideMovie()">
                <HeroIconsOutline
                    name="x"
                    class="hidden w-6 h-6 text-white md:block"
                />
                <HeroIconsOutline
                    name="arrow-left"
                    class="block w-6 h-6 text-white md:hidden"
                />
            </button>
        </div>
        <img
            v-if="skeleton"
            class="block w-full rounded-md bg-black-300 animate-pulse"
            src="images/placeholder.jpeg"
        />
        <img
            class="block object-cover w-full rounded-md"
            :class="{ hidden: skeleton }"
            :src="backdrop"
            @load="skeleton = false"
        />
        <div class="grid grid-cols-10 py-3">
            <p class="col-span-8 text-lg">{{ getMovieData("title") }}</p>
            <div class="flex items-center justify-end col-span-1">
                <button @click="handleLike()">
                    <HeroIconsOutline
                        name="heart"
                        class="block w-6 h-6 text-white"
                        :class="{ 'text-red-500': getMovieData('liked') }"
                    />
                </button>
            </div>
            <div class="flex items-center justify-end col-span-1">
                <button @click="handleWatch()">
                    <HeroIconsOutline
                        name="eye"
                        class="block w-6 h-6 text-white"
                        :class="{ 'text-blue-500': getMovieData('watched') }"
                    />
                </button>
            </div>
        </div>
        <div class="py-3 text-base text-gray-400">
            <div class="py-2 text-lg text-white border-b border-black-300">
                <span>Information</span>
            </div>
            <div
                v-for="(information, index) in informations"
                :key="index"
                class="flex justify-between py-2 border-b border-black-300"
            >
                <span>{{ information.title }}</span>
                <span class="text-white">{{ information.data }}</span>
            </div>
        </div>
        <div class="py-3 text-base text-gray-400">
            <div class="py-2 text-lg text-white border-b border-black-300">
                <span>Overview</span>
            </div>
            <p class="py-2">{{ getMovieData("overview") }}</p>
        </div>
        <div class="py-3 text-base text-gray-400">
            <div class="py-2 text-lg text-white border-b border-black-300">
                <span>Production companies</span>
            </div>
            <div
                v-for="(company, index) in getMovieData('production_companies')"
                :key="index"
                class="flex justify-between py-2 border-b border-black-300"
            >
                <span>{{ company.name }}</span>
                <span class="text-white">{{ company.origin_country }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { mapActions, mapGetters } from "vuex";
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";

export default defineComponent({
    components: {
        HeroIconsOutline,
    },

    data() {
        return {
            skeleton: true,
        };
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie"]),
        informations() {
            return [
                {
                    title: "Release date",
                    data: this.getMovieData("release_date"),
                },
                {
                    title: "Vote average",
                    data: this.getMovieData("vote_average"),
                },
                {
                    title: "Runtime",
                    data: this.movieRuntime,
                },
            ];
        },
        backdrop() {
            if (this.getSelectedMovie?.backdrop_path == null) {
                return "images/placeholder.jpeg";
            }

            return (
                "https://image.tmdb.org/t/p/original" +
                this.getSelectedMovie?.backdrop_path
            );
        },
        movieRuntime() {
            let runtime = this.getMovieData("runtime");

            if (runtime < 60) {
                return `${runtime}min`;
            }

            if (runtime % 60 === 0) {
                return `${runtime / 60}h`;
            }

            return `${parseInt(runtime / 60)}h ${runtime % 60}min`;
        },
    },

    methods: {
        ...mapActions("movie", ["selectMovie", "hideMovie", "updateData"]),
        getMovieData(data) {
            if (this.getSelectedMovie === null) {
                return "";
            }
            return this.getSelectedMovie[data];
        },
        handleLike() {
            // axios.post(route("movies.like", this.getSelectedMovie.id));

            this.$inertia.post(
                route("movies.like", this.getSelectedMovie.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );

            this.selectMovie(this.getSelectedMovie.id);

            this.updateData({
                route: "likes",
                movie_id: this.getSelectedMovie.id,
            });
        },
        handleWatch() {
            // axios.post(route("movies.watch", this.getSelectedMovie.id));

            this.$inertia.post(
                route("movies.watch", this.getSelectedMovie.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );

            this.selectMovie(this.getSelectedMovie.id);

            this.updateData({
                route: "watched",
                movie_id: this.getSelectedMovie.id,
            });
        },
    },
});
</script>