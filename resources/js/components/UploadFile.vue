<template>
    <div>
        <h2 class="text-center">Upload Files</h2>
        <file-pond
                name="files"
                ref="pond"
                label-idle="Drop files here..."
                v-bind:allow-multiple="true"
                :server="api"
                v-bind:files="files"
                v-on:init="handleFilePondInit"
        />
    </div>
</template>

<script>
    import vueFilePond from 'vue-filepond';
    import "filepond/dist/filepond.min.css";
    import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
    import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
    import FilePondPluginImagePreview from "filepond-plugin-image-preview";

    const FilePond = vueFilePond(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    );

    export default {
        data() {
            return {
                files: [],
                api: `/api/users/upload/${this.$route.params.id}`,
                user: {}
            }
        },
        created() {
            this.axios
                .get(`http://user-management.local/api/users/${this.$route.params.id}`)
                .then((res) => {
                    this.user = res.data;
                });
        },
        methods: {
            handleFilePondInit(){
              console.log('Iniitialized!');
            },
        },
        components: {
            FilePond
        },
    }
</script>
<style scoped></style>