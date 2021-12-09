<template>
    <div class="flex flex-col">
        <div
            tabindex="0"
            class="
                block
                rounded-md
                group
                p-0.5
                border-transparent border-2
                focus:border-purple-300
                hover:border-purple-300
                outline-none
                h-full
                cursor-pointer
            "
            :class="{
                'border-purple-500 focus:border-purple-500': isSelected(movie),
            }"
            @click="selectMovie(movie)"
            @keydown.enter="selectMovie(movie)"
            @keydown.esc="selectMovie(null)"
        >
            <img
                class="block object-cover h-full rounded-md cursor-pointer pointer-events-none bg-black-300"
                :class="{ 'animate-pulse': skeleton }"
                :src="image(movie)"
                @load="skeleton = false"
            />
        </div>
        <div>
            <p class="text-sm truncate px-0.5 text-white">
                {{ movie.title }}
            </p>
            <p class="text-sm truncate px-0.5 text-white">
                {{ movie.release_date }}
            </p>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { mapActions, mapGetters } from "vuex";

export default defineComponent({
    props: {
        movie: Object,
    },

    data() {
        return {
            skeleton: true,
        };
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie"]),
    },

    methods: {
        ...mapActions("movie", ["selectMovie"]),
        image(movie) {
            if (movie.backdrop_path == null) {
                return "images/placeholder.jpeg";
            }

            return "https://image.tmdb.org/t/p/w500" + movie.backdrop_path;
        },
        isSelected(movie) {
            return movie.id === this.getSelectedMovie?.id;
        },
    },
});
</script>