<template>
    <Layout>
        <AnnouncementForm :all-categories="allCategories" :all-types="allTypes" :announcement="announcement"
                          mode="create"
                          @submit="submit"/>
    </Layout>

</template>
<script>
import Layout from "@/Pages/Dashboard/Layout/Layout.vue";
import {Inertia} from "@inertiajs/inertia";
import {Link} from "@inertiajs/vue3";
import {useForm} from '@inertiajs/inertia-vue3';
import AnnouncementForm from "@/Pages/Dashboard/Announcement/AnnouncementForm.vue";

export default {
    name: "AnnouncementCreate",
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
    methods: {
        submit(form) {
            console.log('-----------------');
            console.log(form);
            console.log('-----------------');
        },
    },
    watch: {}
};
</script>
