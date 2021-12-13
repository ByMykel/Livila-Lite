<template>
    <div class="flex flex-col">
        <div
            tabindex="0"
            class="
                block
                relative
                rounded-md
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
            @click="handleClick()"
            @keydown.esc="hideMovie()"
        >
            <transition name="heart-icon">
                <div
                    v-show="movie.liked"
                    class="
                        absolute
                        flex
                        justify-center
                        items-end
                        rounded-b-md
                        top-0.5
                        right-2.5
                        sm:w-5
                        w-4
                        sm:h-6
                        h-5
                        bg-red-500
                    "
                >
                    <transition
                        enter-active-class="transition duration-200 ease-in"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <HeroIconsOutline
                            v-show="movie.liked"
                            name="heart"
                            class="w-3 h-3 sm:w-4 sm:h-4 text-white mb-0.5"
                        />
                    </transition>
                </div>
            </transition>
            <img
                class="block object-cover h-full rounded-md cursor-pointer bg-black-300"
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
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";

export default defineComponent({
    props: {
        movie: Object,
    },

    components: {
        HeroIconsOutline,
    },

    data() {
        return {
            skeleton: true,
            clicks: 0,
            timer: null,
        };
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie"]),
    },

    methods: {
        ...mapActions("movie", ["selectMovie", "showMovie", "hideMovie"]),
        image(movie) {
            if (movie.backdrop_path == null) {
                return "images/placeholder.jpeg";
            }

            return "https://image.tmdb.org/t/p/w500" + movie.backdrop_path;
        },
        isSelected(movie) {
            if (this.getSelectedMovie?.id === undefined) {
                return false;
            }

            return movie.id === this.getSelectedMovie?.id;
        },
        handleLike() {
            this.$inertia.post(
                route("movies.like", this.movie.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );

            this.movie.liked = !this.movie.liked;
        },
        handleClick() {
            this.clicks++;
            if (this.clicks === 1) {
                this.timer = setTimeout(() => {
                    this.selectMovie({ ...this.movie });
                    this.showMovie();
                    this.clicks = 0;
                }, 300);
            } else {
                clearTimeout(this.timer);
                this.clicks = 0;
                this.handleLike();

                if (this.movie.id === this.getSelectedMovie?.id) {
                    this.selectMovie({ ...this.movie });
                }
            }
        },
    },
});
</script>

<style scoped>
.heart-icon-enter-active,
.heart-icon-leave-active {
    transition: height 0.2s;
}
.heart-icon-enter-active {
    height: 1.5rem;
}
.heart-icon-enter-from,
.heart-icon-leave-active {
    height: 0;
}
.heart-icon-leave-from {
    height: 1.5rem;
}
</style>