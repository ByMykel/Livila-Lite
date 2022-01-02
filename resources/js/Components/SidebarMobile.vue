<template>
    <div
        class="z-50 flex items-center w-full h-12 shadow bg-black-500 md:hidden"
    >
        <button
            class="h-full px-2.5 border-r border-black-400"
            @click="showSidebar = !showSidebar"
        >
            <HeroIconsOutline name="menu-alt2" class="w-6 h-6 text-gray-300" />
        </button>
        <div v-if="showSidebar" class="relative">
            <div
                class="fixed inset-0 w-full h-screen bg-opacity-80 bg-black-400"
                @click.self="showSidebar = false"
            >
                <div class="relative w-full bg-black-500 rounded-b-md">
                    <div class="flex justify-center w-full py-6">
                        <img class="w-28" src="/images/logo-text.svg" />
                    </div>
                    <div class="py-2 space-y-0.5">
                        <div
                            class="px-2"
                            v-for="(link, index) in links"
                            :key="index"
                        >
                            <a
                                :href="route(link.route)"
                                class="block py-2 rounded-md"
                                :class="[
                                    route().current(link.route)
                                        ? 'bg-black-400 text-white'
                                        : 'text-gray-300 hover:text-white hover:bg-black-400',
                                ]"
                            >
                                <div class="flex justify-center">
                                    <HeroIconsOutline
                                        class="w-6 h-6"
                                        :name="link.icon"
                                    />
                                </div>
                                <div class="flex justify-center">
                                    {{ link.name }}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
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
        Sidebar,
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