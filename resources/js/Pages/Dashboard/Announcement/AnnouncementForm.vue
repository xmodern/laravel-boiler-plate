<template>
    <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Type</span>
                    </div>
                    <select v-model="form.type_id" :disabled="mode==='show'" class="select select-bordered w-full">
                        <option value="">Select Type</option>
                        <option v-for="type in allTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                    </select>
                </label>
                <div v-if="$page.props.errors.type_id" class="text-red-500 text-sm">
                    {{ $page.props.errors.type_id }}
                </div>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Category</span>
                    </div>
                    <select v-model="form.category_id" :disabled="mode==='show'" class="select select-bordered w-full">
                        <option value="">Select Category</option>
                        <option v-for="category in allCategories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </label>
                <div v-if="$page.props.errors.category_id" class="text-red-500 text-sm">
                    {{ $page.props.errors.category_id }}
                </div>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Title</span>
                    </div>
                    <input v-model="form.title" :disabled="mode==='show'" class="input input-bordered w-full"
                           placeholder="Type here"
                           type="text"/>
                </label>
                <div v-if="$page.props.errors.title" class="text-red-500 text-sm">
                    {{ $page.props.errors.title }}
                </div>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Position</span>
                    </div>
                    <input v-model="form.position" :disabled="mode==='show'" class="input input-bordered w-full"
                           disabled placeholder="Type here"
                           type="text"/>
                </label>
                <div v-if="$page.props.errors.position" class="text-red-500 text-sm">
                    {{ $page.props.errors.position }}
                </div>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Degree</span>
                    </div>
                    <input v-model="form.degree" :disabled="mode==='show'" class="input input-bordered w-full"
                           placeholder="Type here"
                           type="text"/>
                </label>
                <div v-if="$page.props.errors.degree" class="text-red-500 text-sm">
                    {{ $page.props.errors.degree }}
                </div>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Open Position</span>
                    </div>
                    <input v-model="form.open_position" :disabled="mode==='show'" class="input input-bordered w-full"
                           placeholder="Type here"
                           type="number"/>
                </label>
                <div v-if="$page.props.errors.open_position" class="text-red-500 text-sm">
                    {{ $page.props.errors.open_position }}
                </div>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Start Date</span>
                    </div>
                    <input v-model="form.start_date" :disabled="mode==='show'" class="input input-bordered w-full"
                           type="date"/>
                </label>
                <div v-if="$page.props.errors.start_date" class="text-red-500 text-sm">
                    {{ $page.props.errors.start_date }}
                </div>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">End Date</span>
                    </div>
                    <input v-model="form.end_date" :disabled="mode==='show'" class="input input-bordered w-full"
                           type="date"/>
                </label>
                <div v-if="$page.props.errors.end_date" class="text-red-500 text-sm">
                    {{ $page.props.errors.end_date }}
                </div>
            </div>
        </div>
        <p class="mt-6">files</p>
        <div class="flex flex-wrap gap-2 mt-1 border border-1 border-gray-300 p-2 rounded-lg min-h-20">
            <div v-for="(doc,index) in displayDocs" :key="index" class="flex flex-col items-center">
                <a :href="doc.url" target="_blank">
                    <div class="flex flex-col items-center">
                        <div class="text-gray-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                 stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 truncate max-w-32">{{ doc.name }}</p>
                    </div>
                </a>
                <button v-if="mode!=='show'" class="text-red-500" type="button" @click="deleteDoc(doc)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.0"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                            stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <button v-if="mode!=='show'" class="w-20 min-h-20 border border-dashed rounded-md" type="button"
                    @click="$refs.documentInput.click()">+
            </button>
        </div>
        <div>
            <label class="form-control w-full">
                <input ref="documentInput" accept="application/pdf" class="input hidden" multiple type="file"
                       @change="handleFileUpload"/>
            </label>
        </div>
        <div v-if="mode!=='show'" class="w-full flex justify-end mt-4">
            <button :disabled="submitting" class="btn btn-primary uppercase" type="submit">Submit</button>
        </div>
    </form>

</template>
<script>
import {Inertia} from "@inertiajs/inertia";
import {Link, router} from "@inertiajs/vue3";
import {useForm} from '@inertiajs/inertia-vue3';

export default {
    name: "AnnouncementForm",
    components: {Link},
    emits: ['submit'],

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
        },
        mode: {
            type: String,
            default: "show"
        },
    },
    mounted() {
        let docs = [];
        if (this.mode === 'create') {
            this.displayDocs = [];
            return;
        }
        if (this.announcement.documents.data.length > 0) {
            this.announcement.documents.data.forEach(doc => {
                docs.push(doc);
            })
        }
        if (this.form.files.length > 0) {
            [...this.form.files].forEach(function (file) {
                const newFile = {
                    id: 0,
                    name: file.name,
                    url: URL.createObjectURL(file)
                }
                docs.push(newFile)
            });
        }
        this.displayDocs = docs;
    },
    data() {
        return {
            form: useForm({
                type_id: this.announcement.type_id ?? "",
                category_id: this.announcement.category_id ?? "",
                title: this.announcement.title,
                position: this.announcement.position,
                degree: this.announcement.degree,
                open_position: this.announcement.open_position,
                start_date: this.announcement.start_date,
                end_date: this.announcement.end_date,
                files: [],
                delete_medias: []
            }),
            displayDocs: [],
            submitting: false
        };
    },
    methods: {
        deleteDoc(doc) {
            this.form.delete_medias.push(doc.id);
            this.displayDocs = this.displayDocs.filter(d => {
                return d.name !== doc.name;
            });
        },
        handleFileUpload(event) {
            this.form.files = event.target.files;
            const files = Array.from(event.target.files);
            files.forEach(file => {
                this.displayDocs.push(file);
            });

        },
        async submit() {
            this.submitting = true;
            let url = '';
            if (this.mode === 'edit') {
                url = this.route('dashboard.announcements.update', this.announcement.id);
            }
            if (this.mode === 'create') {
                url = this.route('dashboard.announcements.store');
            }
            await router.post(url, {
                _method: this.mode === 'edit' ? 'patch' : 'post',
                files: this.form.files,
                type_id: this.form.type_id,
                category_id: this.form.category_id,
                title: this.form.title,
                position: this.form.position,
                degree: this.form.degree,
                open_position: this.form.open_position,
                start_date: this.form.start_date,
                end_date: this.form.end_date,
                delete_medias: this.form.delete_medias
            });
        },
    },
    watch: {},
    computed: {}
};
</script>
