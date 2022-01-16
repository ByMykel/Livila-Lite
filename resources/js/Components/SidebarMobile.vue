<template>
    <div
        class="z-50 flex items-center justify-between w-full h-12 shadow bg-black-500 md:hidden"
    >
        <div class="flex justify-center ml-5">
            <a :href="route('home')">
                <img class="w-9" src="/images/logo.svg" />
            </a>
        </div>
        <div class="flex items-center h-full">
            <div class="mr-2" v-if="$page.props.user === null">
                <a
                    :href="route('login')"
                    class="flex items-center w-full px-2 py-2 text-gray-300 rounded-md hover:text-white focus:text-white hover:bg-black-400 focus:bg-black-400"
                >
                    <div class="flex justify-center text-sm">Sign In</div>
                </a>
            </div>
            <div class="mr-2" v-if="$page.props.user === null">
                <a
                    :href="route('register')"
                    class="flex items-center w-full px-2 py-2 text-gray-300 rounded-md hover:text-white focus:text-white hover:bg-black-400 focus:bg-black-400 bg-black-400"
                >
                    <div class="flex justify-center text-sm">Sign Up</div>
                </a>
            </div>
            <div v-else class="relative mr-2.5">
                <Dropdown />
            </div>
            <button
                class="h-full px-2.5 border-l border-black-400"
                @click="showSidebar = !showSidebar"
            >
                <HeroIconsOutline
                    name="menu-alt2"
                    class="w-6 h-6 text-gray-300"
                />
            </button>
        </div>
        <div v-if="showSidebar" class="relative">
            <div
                class="fixed inset-0 w-full h-screen bg-opacity-80 bg-black-400"
                @click.self="showSidebar = false"
            >
                <div class="relative w-full bg-black-500 rounded-b-md">
                    <div class="flex justify-center w-full py-6">
                        <a :href="route('home')">
                            <img class="w-28" src="/images/logo-text.svg" />
                        </a>
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
import Dropdown from "@/Components/Dropdown.vue";

export default defineComponent({
    components: {
        HeroIconsOutline,
        Sidebar,
        Dropdown,
    },
    data() {
        return {
            showSidebar: false,
        };
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
                        name: "Likes",
                        route: "likes",
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