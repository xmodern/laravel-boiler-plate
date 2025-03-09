<template>
    <div class="w-full">
        <!-- แถบส่วนหัวสีฟ้า -->
        <div
            class="w-full bg-pink-600 h-10 flex items-center px-4 lg:px-32 fixed top-0 left-0 right-0 z-50">
            <p class="">Test Website</p>
        </div>
        <!-- แถบส่วนหัวที่มีเงา -->
        <div
            class="w-full shadow-md h-20 flex items-center justify-between px-4 lg:px-32 fixed top-10 left-0 right-0 z-50 bg-white">
            <!--            <img alt="Logo" class="h-16 mr-2" src="https://www.aru.ac.th/asi/images/logo_asi3.png">-->
            <!-- <Link class="flex items-center" :href="route('index')">
                <h1 class="text-4xl font-bold uppercase">ARU</h1>
                <h1 class="text-4xl font-bold text-blue-600">Teaching Materials</h1>
            </Link> -->
            <div class="flex gap-2">
                <Link
                    :href="route('login')"
                    class="text-[#92392f] px-1 py-0.5 border-[#92392f] border-l-0 border-r-0 border-t-0 border-2 font-bold hidden lg:block ml-10">
                    Login
                </Link>
            </div>

            <!-- เมนูมือถือ -->
            <div class="block lg:hidden">
                <button class="text-blue-600" @click="toggleMenu">
                    <!-- ไอคอนสำหรับเมนูมือถือ (hamburger icon) -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"></path>
                    </svg>
                </button>
                <!-- เมนูที่จะแสดงเมื่อกดปุ่ม -->
                <div v-if="isMenuOpen" class="absolute bg-white shadow-lg rounded-lg mt-2 right-0">
                    <a class="block px-4 py-2 text-blue-600" href="https://www.aru.ac.th/asi">Home</a>
                    <Link :href="route('login')" class="block px-4 py-2 text-blue-600">Login</Link>
                </div>
            </div>
        </div>
        <div class="mt-32">

        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Nav",
    components: {Link},
    data() {
        return {
            isMenuOpen: false,
        }
    },
    methods: {
        logout() {
            Inertia.post(this.route('logout'));
        },
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
        }
    }
};
</script>
<style scoped>
/* เพื่อให้แน่ใจว่าส่วนหัวคงที่ไม่บดบังเนื้อหาของหน้าเว็บ */
.mt-32 {
    margin-top: 8rem; /* 2.5rem (h-10) + 5rem (h-20) = 7.5rem, เพิ่มเป็น 8rem */
}
</style>
