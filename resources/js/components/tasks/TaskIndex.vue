<template>
    <div class="row border-bottom pt-2 pb-2">
        <div class="col-1">
            <a :href="'/organizer/project/' + project.id">{{ project . name }}</a>
        </div>
        <div class="col-1">
            <a :href="'/organizer/project/' + project.id">{{ stage . name }}</a>
        </div>
        <div class="col-1">
            <a :href="'/organizer/task/' + task.id">{{ task . name }}</a>
        </div>
        <div class="col-2">
            {{ this . task . description }}
        </div>
        <div class="col-1">
            <img v-if="responsible.length > 0 && responsible[0].image !== ''" :src="'/organizer/storage/' + responsible[0].image"
                class="user-image img-circle elevation-1" alt="" style="height: 30px; width: 30px;">
            <a class="ml-2" :href="'/organizer/profile/' + responsible[0].id">{{ responsible[0] . name }}
                {{ responsible[0] . lastname }}</a>
        </div>
        <div class="col-1">
            {{ this . task . start_date }}
        </div>
        <div class="col-2">
            <div class="row">
                <div class="col-7">
                    {{ this . task . finish_date }}
                </div>
                <div class="col-5 text-left">
                    <span :class="'badge bg-danger' + (isUrgent ? ' blinking' : '')"
                        v-if="task.finish_date <= now && task.status == 'open' && task.priority =='High'">Urgent!</span>
                    <span class="badge bg-danger"
                        v-if="task.finish_date < today && task.status == 'open'">Expired</span>
                    <span class="badge bg-primary"
                        v-if="task.start_date <= today && task.finish_date >= today && task.status == 'open'">In
                        Progress</span>
                    <span class="badge bg-success"
                        v-if="task.start_date >= today && task.finish_date >= today && task.status == 'open'">Upcoming</span>
                    <span class="badge bg-warning" v-if="task.finish_date == now && task.status == 'open'">Today</span>
                </div>
            </div>
        </div>
        <div class="col-1 text-left">
            <label class="switch">
                <input type="checkbox" v-model="isToggleChecked" @click="updateStatus(this.elementId)">
                <span class="slider round"></span>
            </label>
            <span class='ml-4'>{{ this . toggleStatusText }}</span>
        </div>
        <div class="col-1"><span class="badge bg-primary">{{ this . task . progress }}</span></div>
        <div class="col-1"><span :class="'badge ' + priorityColor">{{ this . task . priority }}</span></div>
    </div>
</template>

<script>
    export default {

        created() {

            this.getIsClosedStatus();
            this.getParentStatusSettings();
        },
        props: ['elementId', 'responsible', 'project', 'stage'],
        data: {
            items: []
        },
        data() {
            return {
                isUrgent: true,
                todo: '',
                isToggleChecked: false,
                toggleStatusText: 'Open Task',
                status: '',
                globalSettings: '',
                task: '',
                priorityColor: '',
                today: new Date().toISOString().split('T')[0],
                now: new Date().toISOString().slice(0, 10).replace('T', ' '),
            };
        },
        mounted() {
            // Toggle the isUrgent value to start or stop the blinking effect
            setInterval(() => {
                this.isUrgent = !this.isUrgent;
            }, 700); // Change blinking speed by adjusting the interval duration
        },
        methods: {
            getParentStatusSettings() {
                axios.get('settings/Project/' + this.parentId + '/settings/task-status').then(
                    response => {
                        this.globalSettings = response.data
                    }
                )
            },

            getIsClosedStatus() {
                axios.get('task/status/' + this.elementId).then(
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
                        if (this.task.priority == 'Low') {
                            this.priorityColor = 'bg-success';
                        }
                        if (this.task.priority == 'Medium') {
                            this.priorityColor = 'bg-warning';
                        }
                        if (this.task.priority == 'High') {
                            this.priorityColor = 'bg-danger';
                        }
                    });
            },
            updateStatus() {
                axios.post('task/status', {
                    id: this.elementId
                });
                this.getIsClosedStatus();
            },

        }
    }
</script>
