<template>
    <div class="w-75">
        <div ref="dropzone" class="btn p-5 bg-info d-block text-center text-light">
            Upload
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
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: "/file/post"
        });
    }
}
</script>

<style scoped>

</style>
