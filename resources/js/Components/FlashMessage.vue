<template>
    <div></div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            success: null,
            error: null,
        }
    },
    methods: {},
    computed: {},
    mounted() {
        this.success = this.$page.props.flash.success;
        if (this.$page.props.flash.success) {
            this.success = this.$page.props.flash.success;
            this.$swal({
                position: 'center',
                icon: 'success',
                title: this.$page.props.flash.success,
                showConfirmButton: false,
                timer: 1500
            })
        }
        if (this.$page.props.flash.error) {
            this.error = this.$page.props.flash.error;
            this.$swal({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
        }
        setTimeout(() => {
            this.success = null;
            this.error = null;
        }, 1500);
    },
    watch: {}

};
</script>
