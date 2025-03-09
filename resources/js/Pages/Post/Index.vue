<template>
    <Layout>
        <div>
            Post Index
        </div>
        <div class="flex flex-wrap gap-2">
            <div v-for="(post,index) in posts" :key="index" class="card w-96 bg-gray-300 card-xs shadow-sm relative">
                <div class="card-body">
                    <h2 class="card-title">{{ index + 1 }}</h2>
                    <p v-if="editForm.id !== post.id">{{ post.content }}</p>
                    <div v-if="editForm.id === post.id" class="w-full">
                        <textarea v-model="editForm.content" class="w-full rounded-md p-2" rows="4"></textarea>
                        <div class="w-full flex justify-end">
                            <button class="btn btn-sm btn-primary" type="button" @click="updatePost">Submit</button>
                        </div>

                    </div>
                </div>
                <div v-if="$page.props.user.role_id === 2" class="absolute top-2 right-2 text-gray-500 flex gap-2">
                    <button class="transition-all ease-in-out duration-300 hover:text-pink-500 hover:scale-110"
                            @click="editPost(post)">
                        <svg class="size-6" fill="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/>
                            <path
                                d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/>
                        </svg>
                    </button>
                    <button
                        class="transition-all ease-in-out duration-300 hover:scale-110 hover:text-red-500 cursor-pointer"
                        @click="handleDeletePost(post)">
                        <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                  fill-rule="evenodd"/>
                        </svg>
                    </button>


                </div>
            </div>
        </div>
        <form @submit.prevent="submit">
            <div class="w-full mt-4 bg-pink-300 p-4 rounded-md shadow-md">
                <div class="w-full flex justify-center">
                    <textarea v-model="form.content" class="w-1/2 rounded-lg p-4" placeholder="" rows="4"></textarea>
                </div>
                <div class="w-full flex justify-center mt-4">
                    <button :disabled="isLoading" class="btn bg-pink-500">Submit</button>
                </div>
            </div>
        </form>
    </Layout>
</template>

<script>
import Layout from "@/Pages/Layout/Layout.vue";
//import TeachingMaterialCard from "@/Pages/Components/TeachingMaterialCard.vue";
import axios from 'axios';
import {Link} from "@inertiajs/vue3";
import {router} from "@inertiajs/vue3";

export default {
    name: "PostIndex",
    components: {Layout},
    props: {
        posts: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            form: {
                id: null,
                content: ""
            },
            editForm: {
                id: null,
                content: ""
            },
            isLoading: false
        }
    },
    mounted() {
    },
    methods: {
        async updatePost() {
            this.isLoading = true;
            const result = await this.$swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Save",
            });
            if (!result.isConfirmed) {
                this.isLoading = false;
                return;
            }
            router.patch(this.route('posts.update', this.editForm.id), this.editForm, {
                onSuccess: async () => {
                    router.reload({only: ['posts'], preserveScroll: true});
                    this.editForm.id = null;
                    this.editForm.content = "";
                    this.isLoading = false;
                }
            })


        },
        editPost(post) {
            this.editForm.id = post.id;
            this.editForm.content = post.content;
        },
        async handleDeletePost(post) {
            const result = await this.$swal.fire({
                title: "Do you want to delete" + post.content,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "red",
            });
            if (!result.isConfirmed) {
                this.isLoading = false;
                return;
            }
            router.delete(this.route('posts.destroy', post.id), {
                onSuccess: () => {
                    this.$swal.fire({
                        title: "Success",
                        text: "You have deleted a post.",
                        icon: "success"
                    });
                }
            });
        },
        async submit() {
            this.isLoading = true;
            const result = await this.$swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Save",
            });
            if (!result.isConfirmed) {
                this.isLoading = false;
                return;
            }
            router.post(this.route('posts.store'), this.form, {
                onSuccess: async () => {
                    await this.$swal.fire({
                        title: "Success",
                        text: "You have created a post.",
                        icon: "success"
                    });
                    window.location.reload();
                }
            });
        }
    }
};
</script>


