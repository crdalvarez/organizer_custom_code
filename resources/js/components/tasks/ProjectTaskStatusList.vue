<template>
    <div class="row border-bottom pt-2 pb-2">
        <div class="col-2">
            <a :href="'/task/' + task.id">{{ task.name }}</a>
        </div>
        <div class="col-2">
            {{ this.task.description }}
        </div>
        <div class="col-2">
            <img v-if="responsible.length > 0 && responsible[0].image !== ''" :src="'/storage/' + responsible[0].image" class="user-image img-circle elevation-1" alt="{{responsible[0].name}} " style="height: 30px; width: 30px;">
            <a class="ml-2" :href="'/profile' + responsible[0].id">{{ responsible[0].name }} {{ responsible[0].lastname }}</a>
        </div>
        <div class="col-1">
            {{ this.task.start_date }}
        </div>
        <div class="col-2">
            {{ this.task.finish_date }}
            <span class="badge bg-danger" v-if="task.finish_date < today && task.status == 'open'">Expired</span>
        </div>
        <div class="col-1 text-left">
            <label class="switch">
                <input type="checkbox" v-model="isToggleChecked" @click="updateStatus(this.elementId)">
                <span class="slider round"></span>

            </label>
            <span :class=statusColor>{{ this.toggleStatusText }}</span>
        </div>
        <div class="col-1"><span class="badge bg-primary">{{ this.task.progress }}</span></div>
        <div class="col-1"><span :class="'badge ' + priorityColor">{{ this.task.priority }}</span></div>
    </div>

</template>

<script>

    export default {

        created() {
            this.getIsClosedStatus();
            this.getParentStatusSettings();
        },

        props: ['elementId', 'responsible'],

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
                task: '',
                priorityColor: '',
                today: new Date().toISOString().split('T')[0],
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
                        this.task = response.data;
                        if (this.task.status == 'closed') {
                            this.toggleStatusText = 'Closed';
                            this.isToggleChecked = true;
                            this.statusColor = 'text-gray ml-4';
                        } else {
                            this.toggleStatusText = 'Open';
                            this.isToggleChecked = false;
                            this.statusColor = 'text-success ml-4';
                        }
                        if(this.task.priority == 'Low'){
                            this.priorityColor = 'bg-success';
                        }
                        if(this.task.priority == 'Medium'){
                            this.priorityColor = 'bg-warning';
                        }
                        if(this.task.priority == 'High'){
                            this.priorityColor = 'bg-danger';
                        }
                    });
            },
            updateStatus() {
                axios.post('/task/status', { id: this.elementId });
                this.getIsClosedStatus();
            },
        }
    }

</script>
