<template>
    <Layout>
        <p>
            Hello {{ user.id }}, How are you doing?
        </p>

        <p>
            Hello {{ number  }}, How are you doing?
        </p>  

        
        <p>
            Hello {{ date  }}, How are you doing?
        </p>
    </Layout>

</template>
<script>
import Layout from "@/Pages/Dashboard/Layout/Layout.vue";

export default {
    name: "DashboardIndex",
    components: {Layout},
    props: {
        user: {
            type: Object,
            required: true
        },
        number: {
            type: Number,
            default: 0
        },
        date: {
            type: String,
            default: "" 
        }
    },
    mounted() {
    },
    data() {
        return {};
    }
};
</script>
