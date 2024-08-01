<template>
    <div class="card mt-5">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="row">
                <div class="col-6">
                    <h3 class="card-title">
                        Files
                    </h3>
                </div>
            </div>
        </div>

        <div class="card-body">
            <ul class="list-unstyled">
                <li>
                    <a href="" class="btn-link text-primary"><i class="far fa-fw fa-file-word"></i>
                        Functional-requirements.docx</a>
                </li>
            </ul>

            <div class="row mb-3 border-bottom" v-for="item in this.timeList">
                <div class="col-8">{{ item.description }}</div>
                <div class="col-4">{{ totalTime(item.created_at, item.finished_at) }}</div>
            </div>

            <div class="row mb-3 border-bottom" v-if="getOpenTrack('Task', this.elementId)">
                <div class="col-8">{{ this.openTime[0].description }}</div>
                <div class="col-4">{{ currentTime }}</div>
            </div>

            <div class="row align-items-center">
                <div class="col-9">
                    <input type="file" class="form-control" id="file" ref="fileInput" @change="handleFileChange" />
                </div>
                <div class="col-3 text-left">
                    <button @click="create()" class="btn btn-primary border float-right"><i
                            class="button btn-primary"></i>
                        Upload</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    props: ['fileable_type', 'fileable_id'],

    data() {
        return {

        }
    },

    methods: {
        handleFileChange(event) {
            this.selectedFile = event.target.files[0];
        },
        create(fileableType, fileableId) {
            let formData = new FormData();
            formData.append('file', this.selectedFile);
            formData.append('fileable_type', this.fileable_type);
            formData.append('fileable_id', this.fileable_id);

            axios.post('/project/file', formData)
                .then(response => {
                    alert(response.data);
                });
        },
        index() {
            axios.get('/task/timer/' + this.elementId).then(
                response => {

                    this.timeList = response.data;

                });
        },
        getOpenTrack() {
            axios.get('/track/task/' + this.elementId).then(
                response => {
                    this.openTime = response.data

                }
            ).then(
                response => {
                    return true;
                }
            )

        },
        deleteItem(itemId) {
            axios.post('/todo/delete', { id: itemId });
            this.index();
        },
        changeStatus(itemId) {
            axios.post('/todo/update', { id: itemId });
            this.index();
        }
    }
}

</script>
