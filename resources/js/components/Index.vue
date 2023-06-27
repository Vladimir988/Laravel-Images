<template>
    <div class="w-75">
        <input v-model="title" type="text" class="form-control mb-3" placeholder="title">
        <div ref="dropzone" class="btn p-5 bg-info d-block text-center text-light mb-3">
            Drop zone
        </div>
        <input @click.prevent="store" type="submit" class="btn btn-primary" value="Add">
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
        }
    },
    methods: {
        store() {
            console.log(this.dropzone.getAcceptedFiles());
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: "/file/post",
            autoProcessQueue: false,
        });
    }
}
</script>

<style scoped>

</style>
