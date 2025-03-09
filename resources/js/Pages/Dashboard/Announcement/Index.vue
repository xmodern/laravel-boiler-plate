<template>
    <Layout>
        <div class="w-full flex justify-end">
            <Link :href="route('dashboard.announcements.create')" class="btn btn-primary">CREATE</Link>
        </div>
        <div class="flex gap-2 w-full">
            <div class="w-80">
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Select Type</span>
                    </div>
                    <select id="announcement_type" v-model="filters.type_id" class="select select-bordered">
                        <option value="">All</option>
                        <option v-for="type in allTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                    </select>
                </label>
            </div>
            <div class="w-80">
                <label class="form-control w-full max-w-xs">
                    <div class="label">
                        <span class="label-text">Select Category</span>
                    </div>
                    <select id="announcement_category" v-model="filters.category_id"
                            class="select select-bordered">
                        <option value="">All</option>
                        <option v-for="category in allCategories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </label>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">ประกาศ</th>
                    <th class="px-6 py-3">ตำแหน่งที่รับสมัคร</th>
                    <th class="px-6 py-3">คุณวุฒิ</th>
                    <th class="px-6 py-3">ประเภท</th>
                    <th class="px-6 py-3">อัตรา</th>
                    <th class="px-6 py-3">วันที่รับสมัคร</th>
                    <th class="px-6 py-3">รายละเอียด</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
                </thead>
                <tbody v-if="announcementsData!=null">
                <tr v-for="(announcement,index) in announcementsData" :key="index"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <!-- <th>{{ index + 1 }}</th> -->
                    <th class="text-center">{{ announcement.id }}</th>
                    <td class="px-6 py-4">
                        <Link :href="route('dashboard.announcements.show',announcement.id)" class="underline">
                            {{ announcement.title }}
                        </Link>
                    </td>
                    <td class="px-6 py-4">{{ announcement.position }}</td>
                    <td class="px-6 py-4">{{ announcement.degree }}</td>
                    <td class="px-6 py-4">{{ announcement.type_name }}</td>
                    <td class="px-6 py-4">{{ announcement.open_position }}</td>
                    <td class="px-6 py-4">
                        <p class="whitespace-nowrap">
                            {{ announcement.display_start_date }} - {{ announcement.display_end_date }}
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-1">
                            <a v-for="(doc,index) in announcement.documents.data" :key="index" :href="doc.url"
                               target="_blank">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                     stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>

                    </td>
                    <td class="px-6 py-4 flex flex-col items-center gap-1">
                        <Link :href="route('dashboard.announcements.edit',announcement.id)"
                              class="btn btn-primary btn-sm w-16">
                            EDIT
                        </Link>
                        <button class="btn btn-error btn-sm w-16 text-gray-100 uppercase" type="button"
                                @click="handleDelete(announcement)">
                            DELETE
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-if="pagination != null" id="pagination" class="mt-4 flex justify-between items-center">
            <div>แสดง {{ pagination.from }} ถึง {{ pagination.to }} จาก {{ pagination.total }} แถว</div>
            <div class="join">
                <button v-for="(pag,index) in pagination.links" :key="index"
                        :class="pag.active ?'btn-active':''"
                        class="join-item btn btn-md" @click="selectPage(pag)">
                    {{ pag.label }}
                </button>
            </div>
        </div>

    </Layout>

</template>
<script>
import Layout from "@/Pages/Dashboard/Layout/Layout.vue";
import {Inertia} from "@inertiajs/inertia";
import {Link, router, useForm} from "@inertiajs/vue3";

export default {
    name: "AnnouncementIndex",
    components: {Layout, Link},
    props: {
        announcements: {
            type: Object,
            required: true
        },
        allTypes: {
            type: Array,
            required: true
        },
        allCategories: {
            type: Array,
            required: true
        }
    },
    mounted() {
        this.pagination = this.announcements.meta.pagination;
        this.announcementsData = this.announcements.data;
    },
    data() {
        return {
            announcementsData: null,
            pagination: null,
            filters: {
                type_id: new URLSearchParams(window.location.search).get('type_id') ?? "",
                category_id: new URLSearchParams(window.location.search).get('category_id') ?? ""
            }
        };
    },
    methods: {
        selectPage(pag) {
            Inertia.get(pag.url);
        },
        handleDelete(announcement) {
            this.$swal.fire({
                title: "คุณต้องการที่จะลบประกาศ " + announcement.title + '?',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: false,
                denyButtonText: 'ลบ'
            }).then((result) => {
                if (result.isDenied) {
                    Inertia.delete(this.route('dashboard.announcements.destroy', announcement.id));
                    window.location.reload();
                }
            });
        }
    },
    watch: {
        filters: {
            handler() {
                Inertia.get(this.route('dashboard.announcements.index'), {
                    type_id: this.filters.type_id,
                    category_id: this.filters.category_id
                });
            },
            deep: true
        }
    }
};
</script>
