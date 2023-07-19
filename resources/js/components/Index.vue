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
                @image-removed="handleImageRemoved"
            >
            </vue-editor>
        </div>
        <input @click.prevent="update" type="submit" class="btn btn-primary" value="Update">
        <div class="mt-5">
            <div v-if="post">
                <h4>{{ post.title }}</h4>
                <div v-for="image in post.images">
                    <img :src="image.preview_url" :alt="post.title" class="mb-3 preview">
                    <img :src="image.url" :alt="post.title" class="mb-3 w-100">
                </div>
                <div v-html="post.content"></div>
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
            imagesIdsForDelete: [],
            imagesUrlsForDelete: [],
        }
    },
    methods: {
        update() {
            let data = new FormData();
            const files  = this.dropzone.getAcceptedFiles();
            files.forEach(file => {
                data.append('images[]', file);
                this.dropzone.removeFile(file);
            });

            this.imagesIdsForDelete.forEach(idForDelete => {
                data.append('image_ids_for_delete[]', idForDelete);
            });

            this.imagesUrlsForDelete.forEach(urlForDelete => {
                data.append('image_urls_for_delete[]', urlForDelete);
            });

            data.append('title', this.title);
            data.append('content', this.content);
            data.append('_method', 'PATCH');
            this.title = '';
            this.content = '';
            axios.post(`/api/posts/${this.post.id}`, data).then(() => {
                let previews = this.dropzone.previewsContainer.querySelectorAll('.dz-image-preview');
                previews.forEach(preview => {
                    preview.remove();
                });
                this.getPost();
            });
        },
        getPost() {
            axios.get('/api/posts').then(response => {
                this.post = response.data.data;

                this.title = this.post.title;
                this.content = this.post.content;

                this.post.images.forEach(image => {
                    let file = { id: image.id, name: image.name, size: image.size };
                    this.dropzone.displayExistingFile(file, image.preview_url);
                });
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
        },
        handleImageRemoved(url) {
            this.imagesUrlsForDelete.push(url);
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
            addRemoveLinks: true,
        });

        this.dropzone.on('removedfile', (file) => {
            this.imagesIdsForDelete.push(file.id);
        });

        this.getPost();
    }
}
</script>

<style>
img.w-100 {
    width: 100%;
}
.dz-success-mark,
.dz-error-mark {
    display: none;
}
</style>
