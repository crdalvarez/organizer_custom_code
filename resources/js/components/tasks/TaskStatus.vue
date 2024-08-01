<template>
    <div>
        <div class="row mt-5">
            <div class="col-9"></div>
            <div class="col-2 text-right">
                <h4 :class=statusColor>{{ this.toggleStatusText }}</h4>
            </div>
            <div class="col-1 text-right">
                <label class="switch">
                    <input type="checkbox" v-model="isToggleChecked" @click="updateStatus(this.elementId)">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    created() {
        this.getIsClosedStatus();
        this.getParentStatusSettings();
    },
    props: ['elementId', 'parentId'],
    data: {
        items: []
    },
    data() {
        return {
            todo: '',
            isToggleChecked: false,
            toggleStatusText: 'Open Task',
            status: '',
            globalSettings: '',
        };
    },
    methods: {
        getParentStatusSettings() {
            axios.get('/settings/Project/' + this.parentId + '/settings/task-status').then(
                response => {
                    this.globalSettings = response.data
                }
            )
        },
        getIsClosedStatus() {
            axios.get('/task/status/' + this.elementId).then(
                response => {
                    if (response.data.status == 'closed') {

                        this.toggleStatusText = 'Closed Task';
                        this.isToggleChecked = true;
                        this.statusColor = 'text-gray';
                    } else {

                        this.toggleStatusText = 'Open Task';
                        this.isToggleChecked = false;
                        this.statusColor = 'text-success';
                    }
                    this.status = response.data;

                });
        },
        updateStatus() {
            axios.post('/task/status', { id: this.elementId }).then(
                response=>{
                    location.reload();
                }
            );
            this.getIsClosedStatus();
        },
    }
}

</script>
