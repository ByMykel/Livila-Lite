<template>
    <div class="px-4 text-white bg-black-400 no-scrollbar">
        <div class="flex items-center w-full py-3 md:justify-end">
            <button @click="selectMovie(null)">
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
        <img class="block object-cover rounded-md" :src="backdrop" alt="" />
        <div class="grid grid-cols-10 py-3">
            <p class="col-span-9 text-lg">{{ getMovieData("title") }}</p>
            <div class="flex items-center justify-end col-span-1">
                <button @click="handleLike()">
                    <HeroIconsOutline
                        name="heart"
                        class="block w-6 h-6 text-white"
                        :class="{ 'text-red-500': getMovieData('liked') }"
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
            ];
        },
        backdrop() {
            if (this.getSelectedMovie === null) {
                return "";
            }

            return (
                "https://image.tmdb.org/t/p/original" +
                this.getSelectedMovie?.backdrop_path
            );
        },
    },
    
    methods: {
        ...mapActions("movie", ["selectMovie"]),
        getMovieData(data) {
            if (this.getSelectedMovie === null) {
                return "";
            }
            return this.getSelectedMovie[data];
        },
        handleLike() {
            this.$inertia.post(
                route("movies.like", this.getSelectedMovie.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );

            this.selectMovie({
                ...this.getSelectedMovie,
                liked: !this.getSelectedMovie.liked,
            });
        },
    },
});
</script>