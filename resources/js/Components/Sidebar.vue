<template>
    <div class="h-screen space-y-0.5 bg-black-500 w-28">
        <div class="flex justify-center my-6">
            <img class="w-10" src="/images/logo.svg" />
        </div>
        <div class="w-full px-2" v-for="(link, index) in links" :key="index">
            <a
                :href="route(link.route)"
                class="block py-2 text-gray-300 rounded-md hover:text-white hover:bg-black-400"
            >
                <div class="flex justify-center">
                    <HeroIconsOutline class="w-6 h-6" :name="link.icon" />
                </div>
                <div class="flex justify-center">{{ link.name }}</div>
            </a>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";

export default defineComponent({
    components: {
        HeroIconsOutline,
    },
    data() {
        return {
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