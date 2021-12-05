<template>
    <div class="flex items-center w-full h-12 shadow bg-black-500 md:hidden">
        <button class="h-full px-2.5 border-r border-black-400" @click="showSidebar = !showSidebar">
            <HeroIconsOutline name="menu-alt2" class="w-6 h-6 text-gray-300" />
        </button>
        <div v-if="showSidebar" class="relative">
            <div class="fixed top-0 left-0 w-full h-screen bg-opacity-80 bg-black-400" @click.self="showSidebar = false">
                <Sidebar class="fixed top-0" />
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";
import Sidebar from "@/Components/Sidebar.vue";

export default defineComponent({
    components: {
        HeroIconsOutline,
        Sidebar
    },
    
    data() {
        return {
            showSidebar: false,
            links: [
                {
                    name: "Movies",
                    route: "movies",
                    icon: "film",
                },
                {
                    name: "Liked",
                    route: "liked",
                    icon: "heart",
                },
                {
                    name: "Watched",
                    route: "watched",
                    icon: "eye",
                },
            ],
        };
    },
});
</script>