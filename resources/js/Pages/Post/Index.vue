<template>
    <Layout>
        <div>
            Post Index
        </div>
        <div class="flex flex-wrap gap-2">
            <div v-for="(post,index) in posts" :key="index" class="card w-96 bg-gray-300 card-xs shadow-sm relative">
                <div class="card-body">
                    <h2 class="card-title">{{ index + 1 }}</h2>
                    <div v-if="editForm.id !== post.id">
                        <div v-if="post.image === undefined" class="w-full bg-gray-400 h-40 rounded-lg"></div>
                        <div v-if="post.image !== undefined"
                             class="w-full bg-gray-400 h-40 rounded-lg overflow-hidden shadow-md border-2 border-white">
                            <img :src="post.image.url" class="w-full h-40 object-cover">
                        </div>
                    </div>
                    <div v-if="editForm.id === post.id">
                        <button v-if="editingPreviewImage === null"
                                class="w-full border border-dashed h-40 rounded-lg cursor-pointer flex justify-center items-center text-gray-500"
                                type="button"
                                @click="$refs.editImageInputRef.click()">
                            <svg class="size-6" fill="none" stroke="currentColor" stroke-width="1.5"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button v-if="editingPreviewImage !== null "
                                class="w-full h-40 rounded-lg overflow-hidden border-2 border-white shadow-md"
                                type="button"
                                @click="$refs.editImageInputRef.click()">
                            <img :src="editingPreviewImage" class="w-full h-40 object-cover">
                        </button>
                    </div>

                    <p v-if="editForm.id !== post.id">{{ post.content }}</p>
                    <div v-if="editForm.id === post.id" class="w-full">
                        <textarea v-model="editForm.content" class="w-full rounded-md p-2" rows="4"></textarea>
                        <p class="text-red-500 text-sm">{{ $page.props.errors.content }}</p>
                        <div class="w-full flex justify-end gap-1">
                            <button class="btn btn-sm bg-gray-300 text-gray-500" type="button" @click="resetEditForm">
                                Cancel
                            </button>
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
                <div class="flex justify-end px-4 text-gray-500 text-sm">
                    <p> {{ post.user.name }}</p>
                </div>
                <div class="flex justify-end px-4 text-gray-500 text-sm">
                    <p>
                        {{ post.display_created_at }}
                    </p>
                </div>
                <div class="flex justify-end px-4 pb-4 text-gray-500 text-sm">
                    <p>
                        {{ post.role.name }}
                    </p>
                </div>
            </div>
        </div>
        <form @submit.prevent="submit">
            <div class="w-full mt-4 bg-pink-300 p-4 rounded-md shadow-md">
                <div class="w-full flex justify-center">
                    <textarea v-model="form.content" class="w-1/2 rounded-lg p-4" placeholder="" rows="4"></textarea>
                </div>
                <div class="flex justify-center">
                    <p v-if="$page.props.errors.content" class="text-red-500">*{{ $page.props.errors.content }}</p>
                </div>

                <div class="w-full flex justify-center my-4">
                    <button
                        v-if="!previewImage"
                        class="w-60 h-60 border border-dashed flex justify-center items-center text-white cursor-pointer"
                        type="button"
                        @click="$refs.photoInputRef.click()">
                        <svg class="size-6" fill="none" stroke="currentColor" stroke-width="1.5"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4.5v15m7.5-7.5h-15" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div v-if="previewImage"
                         class="w-60 h-60 border border-dashed flex justify-center items-center text-white cursor-pointer"
                         @click="$refs.photoInputRef.click()">
                        <img :src="previewImage" class="w-60 h-60 object-cover">
                    </div>
                </div>
                <input ref="editImageInputRef" accept="image/*" class="hidden" type="file"
                       @change="handleSelectEditImage">
                <input ref="photoInputRef" accept="image/*" class="hidden" type="file"
                       @change="handleSelectImage">
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
                content: "",
                image: null
            },
            editForm: {
                _method: "patch",
                id: null,
                content: "",
                image: null
            },
            isLoading: false,
            previewImage: null,
            editingPreviewImage: null,
        }
    },
    mounted() {
    },
    methods: {
        resetEditForm() {
            this.editingPreviewImage = null;
            this.editForm.id = null;
            this.editForm.content = "";
            this.editForm.image = null;
        },
        handleSelectEditImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const blobUrl = URL.createObjectURL(file);
            this.editingPreviewImage = blobUrl;
            this.editForm.image = file;
        },
        handleSelectImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const blobUrl = URL.createObjectURL(file);
            this.previewImage = blobUrl;
            this.form.image = file;
        },
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
            router.post(this.route('posts.update', this.editForm.id), this.editForm, {
                onSuccess: async () => {
                    router.reload({only: ['posts'], preserveScroll: true});
                    await this.$swal.fire({
                        title: "Success",
                        text: "You have updated successfully.",
                        icon: "success"
                    });
                    this.editForm.id = null;
                    this.editForm.content = "";
                    this.editForm.image = null;
                    this.isLoading = false;
                }
            })

        },
        editPost(post) {
            this.editForm.id = post.id;
            this.editForm.content = post.content;
            if (post.image !== undefined) {
                this.editingPreviewImage = post.image.url;
            }
            if (post.image === undefined) {
                this.editingPreviewImage = null;
            }

            console.log('-----------------');
            console.log(this.editingPreviewImage);
            console.log('-----------------');
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
                },
                onError: () => {
                    this.isLoading = false;
                }
            });
        }
    }
};
</script>
