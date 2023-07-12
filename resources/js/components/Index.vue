<template>
    <div class="w-75">
        <input v-model="title" type="text" class="form-control mb-3" placeholder="title">
        <div ref="dropzone" class="btn p-5 bg-info d-block text-center text-light mb-3">
            Drop zone
        </div>
        <div class="mb-3">
            <vue-editor
                v-model="content"
                useCustomImageHandler
                @image-added="handleImageAdded"
            >
            </vue-editor>
        </div>
        <input @click.prevent="store" type="submit" class="btn btn-primary" value="Add">
        <div class="mt-5">
            <div v-if="post">
                <h4>{{ post.title }}</h4>
                <div v-for="image in post.images">
                    <img :src="image.preview_url" :alt="post.title" class="mb-3">
                    <img :src="image.url" :alt="post.title" class="mb-3 w-100">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Dropzone from 'dropzone';
import { VueEditor } from "vue2-editor";
export default {
    name: "Index",
    components: {
        VueEditor
    },
    data() {
        return {
            dropzone: null,
            title: null,
            post: null,
            content: null,
        }
    },
    methods: {
        store() {
            let data = new FormData();
            const files  = this.dropzone.getAcceptedFiles();
            files.forEach(file => {
                data.append('images[]', file);
                this.dropzone.removeFile(file);
            });
            data.append('title', this.title);
            this.title = '';
            axios.post('/api/posts', data).then(() => {
                this.getPost();
            });
        },
        getPost() {
            axios.get('/api/posts').then(response => {
                this.post = response.data.data;
            });
        },
        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            const data = new FormData();
            data.append('image', file);

            axios.post('/api/posts/images', data).then(response => {
                const url = response.data.url;
                Editor.insertEmbed(cursorLocation, "image", url);
                resetUploader();
            }).catch(error => {
                console.log(error);
            });
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
            addRemoveLinks: true,
        });
        this.getPost();
    }
}
</script>

<style scoped>

</style>
