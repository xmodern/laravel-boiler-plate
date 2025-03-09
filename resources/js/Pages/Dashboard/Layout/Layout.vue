<template>
    <div>
        <nav class="bg-blue-300 fixed top-0 z-30 w-full">
            <div class="navbar">
                <div class="flex-1">
                    <a class="btn btn-ghost text-xl">Logo</a>
                </div>
                <div class="flex-none gap-2">
                    <div class="dropdown dropdown-end">
                        <div class="btn btn-ghost btn-circle avatar" role="button" tabindex="0">
                            <div class="w-10 rounded-full">
                                <img alt="Tailwind CSS Navbar component"
                                     src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg"/>
                            </div>
                        </div>
                        <ul class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52"
                            tabindex="0">
                            <li>
                                <Link :href="route('profile.show')" class="justify-between">
                                    Profile
                                </Link>
                            </li>
                            <li><a>Settings</a></li>
                            <li>
                                <button @click.prevent="logout">Logout</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="fixed left-0 pt-16">
            <div class="drawer lg:drawer-open">
                <input id="my-drawer-2" class="drawer-toggle" type="checkbox"/>
                <div class="drawer-content flex flex-col items-center justify-center">
                    <!-- Page content here -->
                    <label class="btn btn-primary drawer-button lg:hidden" for="my-drawer-2">Open drawer</label>

                </div>
                <div class="drawer-side">
                    <label aria-label="close sidebar" class="drawer-overlay" for="my-drawer-2"></label>
                    <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
                        <!-- Sidebar content here -->

                        <side-bar/>
                    </ul>
                </div>
            </div>
        </div>
        <div class="pl-80 pt-16">
            <div class="px-8 py-8 overscroll-y-auto">
                <FlashMessage/>
                <slot></slot>
            </div>
        </div>
    </div>

</template>
<script>
import SideBar from "@/Pages/Dashboard/Layout/SideBar.vue";
import {Inertia} from "@inertiajs/inertia";
import {Link} from '@inertiajs/inertia-vue3';
import FlashMessage from "@/Components/FlashMessage.vue";

export default {
    name: "DashboardLayout",
    methods: {
        logout() {
            Inertia.post(this.route('logout'));
        }
    },
    components: {SideBar, Link, FlashMessage},
    data() {
        return {};
    },
};
</script>
