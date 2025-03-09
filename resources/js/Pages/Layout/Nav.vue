<template>
    <div class="w-full">
        <!-- แถบส่วนหัวสีฟ้า -->
        <div class="w-full bg-[#92392f] h-10 flex items-center px-4 lg:px-32 fixed top-0 left-0 right-0 z-50">
            <p class="text-white">Ayutthaya Studies Institute</p>
        </div>
        <!-- แถบส่วนหัวที่มีเงา -->
        <div class="w-full shadow-md h-20 flex items-center justify-between px-4 lg:px-32 fixed top-10 left-0 right-0 z-50 bg-white">
            <img src="https://www.aru.ac.th/asi/images/logo_asi3.png" alt="Logo" class="h-16 mr-2">
            <!-- <Link class="flex items-center" :href="route('index')">
                <h1 class="text-4xl font-bold uppercase">ARU</h1>
                <h1 class="text-4xl font-bold text-blue-600">Teaching Materials</h1>
            </Link> -->
            <div class="flex gap-2">
                <a href="https://www.aru.ac.th/asi"
                    class="text-[#92392f] px-1 py-0.5 border-[#92392f] border-l-0 border-r-0 border-t-0 border-2 font-bold hidden lg:block"
                    >
                    Home
                </a>
                 <Link
                    class="text-[#92392f] px-1 py-0.5 border-[#92392f] border-l-0 border-r-0 border-t-0 border-2 font-bold hidden lg:block ml-10"
                    :href="route('login')">
                    Login
                </Link>
            </div>

            <!-- เมนูมือถือ -->
            <div class="block lg:hidden">
                <button @click="toggleMenu" class="text-blue-600">
                    <!-- ไอคอนสำหรับเมนูมือถือ (hamburger icon) -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <!-- เมนูที่จะแสดงเมื่อกดปุ่ม -->
                <div v-if="isMenuOpen" class="absolute bg-white shadow-lg rounded-lg mt-2 right-0">
                    <a href="https://www.aru.ac.th/asi" class="block px-4 py-2 text-blue-600">Home</a>
                    <Link class="block px-4 py-2 text-blue-600" :href="route('login')">Login</Link>
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
