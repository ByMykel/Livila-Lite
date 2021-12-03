<template>
    <div class="fixed flex w-full h-screen">
        <Sidebar />
        <slot></slot>
        <MovieDetails
            v-show="getSelectedMovie != null"
            class="hidden h-screen overflow-auto overflow-x-hidden text-5xl border-l-2 border-black-300 md:block"
            style="width: 30rem"
        />
        <MovieDetails
            v-show="getSelectedMovie != null"
            class="fixed w-full h-screen overflow-auto overflow-x-hidden text-5xl md:hidden"
        />
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { mapGetters } from "vuex";
import Sidebar from "@/Components/Sidebar.vue";
import MovieDetails from "@/Components/MovieDetails.vue";

export default defineComponent({
    components: {
        Sidebar,
        MovieDetails,
    },

    props: {
        title: String,
    },

    computed: {
        ...mapGetters("movie", ["getSelectedMovie"]),
    },
});
</script>
