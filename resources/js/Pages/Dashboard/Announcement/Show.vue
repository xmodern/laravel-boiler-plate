<template>
    <Layout>
        <div class="w-full flex justify-end">
            <Link :href="route('dashboard.announcements.edit',announcement.id)" class="btn btn-primary">EDIT</Link>
        </div>
        <AnnouncementForm :all-categories="allCategories" :all-types="allTypes" :announcement="announcement"
                          mode="show"/>
    </Layout>

</template>
<script>
import Layout from "@/Pages/Dashboard/Layout/Layout.vue";
import {Inertia} from "@inertiajs/inertia";
import {Link} from "@inertiajs/vue3";
import {useForm} from '@inertiajs/inertia-vue3';
import AnnouncementForm from "@/Pages/Dashboard/Announcement/AnnouncementForm.vue";

export default {
    name: "AnnouncementShow",
    components: {Layout, Link, AnnouncementForm},
    props: {
        announcement: {
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

    },
    data() {
        return {};
    },
    methods: {},
    watch: {}
};
</script>
