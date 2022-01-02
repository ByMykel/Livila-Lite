<template>
    <div class="flex flex-col w-full full-height md:flex-row">
        <Sidebar />
        <SidebarMobile />
        <slot></slot>
        <MovieDetails
            v-show="isShowing"
            class="hidden overflow-auto overflow-x-hidden text-5xl border-l-2 full-height border-black-300 md:block w-96 lg:w-114 2xl:w-122"
        />
        <MovieDetails
            v-show="isShowing"
            class="fixed z-50 w-full overflow-auto overflow-x-hidden text-5xl full-height md:hidden"
        />
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { mapGetters } from "vuex";
import Sidebar from "@/Components/Sidebar.vue";
import SidebarMobile from "@/Components/SidebarMobile.vue";
import MovieDetails from "@/Components/MovieDetails.vue";
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";

export default defineComponent({
    components: {
        Sidebar,
        SidebarMobile,
        MovieDetails,
        HeroIconsOutline,
    },

    props: {
        title: String,
    },

    mounted() {
        this.setDocHeight();

        addEventListener("resize", this.setDocHeight);
        addEventListener("orientationchange", this.setDocHeight);
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie", "isShowing"]),
    },

    methods: {
        setDocHeight() {
            document.documentElement.style.setProperty(
                "--vh",
                `${window.innerHeight / 100}px`
            );
        },
    },
});
</script>

<style scoped>
.full-height {
    height: calc(var(--vh, 1vh) * 100);
}
</style>