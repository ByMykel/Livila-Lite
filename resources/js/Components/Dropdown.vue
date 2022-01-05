<template>
    <div ref="dropdown" v-if="$page.props.user">
        <div>
            <button
                @click="show = !show"
                type="button"
                class="flex text-sm rounded-full bg-black-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-black-500 focus:ring-white"
                id="user-menu"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <img
                    class="rounded-full w-9 h-9"
                    :src="$page.props.user.profile_photo_url"
                    alt=""
                />
            </button>
        </div>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div
                v-if="show"
                class="absolute bottom-0 z-50 w-48 py-1 mt-2 overflow-hidden origin-top-right rounded-md shadow-lg bg-black-300 left-11 ring-1 ring-indigo-500 ring-opacity-30 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu"
            >
                <a
                    :href="route('profile.show')"
                    class="block px-4 py-2 text-sm text-white hover:bg-black-400"
                    role="menuitem"
                    >Settings</a
                >
                <form @submit.prevent="logout">
                    <button
                        class="block w-full px-4 py-2 text-sm text-left text-white hover:bg-black-400"
                        role="menuitem"
                    >
                        Sign out
                    </button>
                </form>
            </div>
        </transition>
    </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
    data() {
        return {
            show: false,
        };
    },
    mounted() {
        document.addEventListener("click", this.onClickOutside);
    },
    beforeUnmount() {
        document.removeEventListener("click", this.onClickOutside);
    },
    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },

        onClickOutside(event) {
            const { dropdown } = this.$refs;
            if (!dropdown || dropdown.contains(event.target)) return;
            this.show = false;
        },
    },
});
</script>
