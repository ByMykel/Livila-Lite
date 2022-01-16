<template>
    <div
        class="flex flex-col duration-200"
        :class="{ 'opacity-20': markAsWatched }"
    >
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
            @keydown.enter="selectMovie({ ...movie }), showMovie()"
            @keydown.esc="hideMovie()"
        >
            <transition name="heart-icon">
                <div
                    v-show="markAsLiked"
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
                        z-10
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
                            v-show="markAsLiked"
                            name="heart"
                            class="w-3 h-3 sm:w-4 sm:h-4 text-white mb-0.5"
                        />
                    </transition>
                </div>
            </transition>
            <img
                v-if="skeleton"
                class="block object-cover h-full rounded-md cursor-pointer bg-black-300 animate-pulse"
                src="images/placeholder.jpeg"
            />
            <img
                class="block object-cover h-full rounded-md cursor-pointer bg-black-300"
                :class="{ hidden: skeleton }"
                :src="image(movie)"
                @load="skeleton = false"
            />
        </div>
        <div>
            <p class="text-sm truncate px-0.5 text-white">
                {{ movie.title }}
            </p>
            <p class="text-sm truncate px-0.5 text-gray-400">
                {{ releaseDate }}
            </p>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { mapActions, mapGetters } from "vuex";
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";
import { Inertia } from "@inertiajs/inertia";

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
        ...mapGetters("movie", ["getSelectedMovie", "isShowing"]),
        releaseDate() {
            if (!this.movie.release_date) {
                return "UNKNOWN";
            }

            return new Date(this.movie.release_date).getFullYear();
        },
        markAsLiked() {
            return !route().current("likes") && this.movie.liked;
        },
        markAsWatched() {
            return !route().current("watched") && this.movie.watched;
        },
    },

    methods: {
        ...mapActions("movie", ["selectMovie", "showMovie", "hideMovie"]),
        image(movie) {
            if (movie.backdrop_path == null) {
                return "images/placeholder.jpeg";
            }

            return "https://image.tmdb.org/t/p/w1280" + movie.backdrop_path;
        },
        isSelected(movie) {
            if (!this.isShowing) {
                return false;
            }

            if (this.getSelectedMovie?.id === undefined) {
                return false;
            }

            return movie.id === this.getSelectedMovie?.id;
        },
        handleWatch() {
            axios
                .post(route("movies.watch", this.movie.id))
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status === 401) {
                            Inertia.visit(route("login"));
                        }
                    }
                });

            this.movie.watched = !this.movie.watched;
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
                this.handleWatch();

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