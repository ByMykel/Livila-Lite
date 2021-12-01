<template>
    <div @click="selectMovie(movie)">
        <div
            tabindex="0"
            class="
                block
                rounded-md
                group
                p-0.5
                border-transparent border-2
                focus:border-purple-300
                outline-none
            "
            :class="{
                'border-purple-500 focus:border-purple-500': isSelected(movie),
            }"
        >
            <img
                class="block object-cover bg-gray-400 rounded-md cursor-pointer"
                :src="image(movie)"
            />
        </div>
        <p class="text-sm truncate px-0.5 text-white">{{ movie.title }}</p>
        <p class="text-sm truncate px-0.5 text-white">
            {{ movie.release_date }}
        </p>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { mapActions, mapGetters } from "vuex";

export default defineComponent({
    props: {
        movie: Object,
    },
    computed: {
        ...mapGetters("movie", ["getSelectedMovie"]),
    },
    methods: {
        ...mapActions("movie", ["selectMovie"]),
        image(movie) {
            return "https://image.tmdb.org/t/p/w500" + movie.backdrop_path;
        },
        isSelected(movie) {
            return movie.id === this.getSelectedMovie?.id;
        },
    },
});
</script>