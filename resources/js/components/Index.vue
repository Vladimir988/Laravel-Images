<template>
    <div class="w-75">
        <input v-model="title" type="text" class="form-control mb-3" placeholder="title">
        <div ref="dropzone" class="btn p-5 bg-info d-block text-center text-light mb-3">
            Drop zone
        </div>
        <input @click.prevent="store" type="submit" class="btn btn-primary" value="Add">

        <div class="mt-5">
            <div>
<!--                <h4>{{ post.title }}</h4>-->
            </div>
        </div>
    </div>
</template>

<script>
import Dropzone from 'dropzone';
export default {
    name: "Index",
    data() {
        return {
            dropzone: null,
            title: null,
            post: null,
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
            axios.post('/api/posts', data);
        },
        getPost() {
            axios.get('/api/posts').then(response => {
                console.log(response);
                this.post = response.data.data;
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
