<template>
    <div class="fixed flex flex-col w-full h-screen md:flex-row">
        <Sidebar class="hidden md:block" />
        <SidebarMobile />
        <slot></slot>
        <MovieDetails
            v-show="getSelectedMovie != null"
            class="hidden h-screen overflow-auto overflow-x-hidden text-5xl border-l-2 border-black-300 md:block w-96 lg:w-114 2xl:w-122"
        />
        <MovieDetails
            v-show="getSelectedMovie != null"
            class="fixed w-full h-screen overflow-auto overflow-x-hidden text-5xl md:hidden"
        />
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { mapActions, mapGetters } from "vuex";
import Sidebar from "@/Components/Sidebar.vue";
import SidebarMobile from "@/Components/SidebarMobile.vue";
import MovieDetails from "@/Components/MovieDetails.vue";
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";

export default defineComponent({
    components: {
        Sidebar,
        SidebarMobile,
        MovieDetails,
        HeroIconsOutline
    },

    props: {
        title: String,
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie"]),
    },

    methods: {
        ...mapActions("movie", ["selectMovie"]),
    },
});
</script>
