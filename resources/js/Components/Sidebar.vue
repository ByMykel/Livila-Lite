<template>
    <div
        class="h-screen space-y-0.5 bg-black-500 w-28 hidden md:block relative"
    >
        <div class="flex justify-center my-6">
            <img class="w-10" src="/images/logo.svg" />
        </div>
        <div class="w-full px-2" v-for="(link, index) in links" :key="index">
            <a
                :href="route(link.route)"
                class="block py-2 rounded-md"
                :class="[
                    route().current(link.route)
                        ? 'bg-black-400 text-white'
                        : 'text-gray-300 hover:text-white hover:bg-black-400 focus:text-white focus:bg-black-400',
                ]"
            >
                <div class="flex justify-center">
                    <HeroIconsOutline class="w-6 h-6" :name="link.icon" />
                </div>
                <div class="flex justify-center">{{ link.name }}</div>
            </a>
        </div>
        <div
            v-if="$page.props.user === null"
            class="
                absolute
                bottom-0
                flex
                w-full
                p-2.5
                border-t border-black-400
            "
        >
            <a
                :href="route('login')"
                class="flex items-center w-full py-2 text-gray-300 rounded-md hover:text-white focus:text-white hover:bg-black-400 focus:bg-black-400"
            >
                <div class="flex justify-center">
                    <HeroIconsOutline class="w-5 h-5 mx-2" name="lock-open" />
                </div>
                <div class="flex justify-center text-sm">Log In</div>
            </a>
        </div>
        <div
            v-else
            class="
                absolute
                bottom-0
                flex
                w-full
                p-2.5
                border-t border-black-450
                justify-center
            "
        >
            <div class="relative">
                <Dropdown />
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import HeroIconsOutline from "@/Components/HeroIconsOutline.vue";
import Dropdown from "@/Components/Dropdown.vue";

export default defineComponent({
    components: {
        HeroIconsOutline,
        Dropdown,
    },
    computed: {
        links() {
            let links = [
                {
                    name: "Movies",
                    route: "movies",
                    icon: "film",
                },
            ];

            if (this.$page.props.user !== null) {
                links.push(
                    {
                        name: "Liked",
                        route: "liked",
                        icon: "heart",
                    },
                    {
                        name: "Watched",
                        route: "watched",
                        icon: "eye",
                    }
                );
            }

            return links;
        },
    },
    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },
    },
});
</script>