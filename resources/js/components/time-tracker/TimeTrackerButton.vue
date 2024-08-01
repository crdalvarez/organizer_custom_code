<template>
    <div class="card">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <div class="row">
                <div class="col-6">
                    <h3 class="card-title">
                        Time Tracker
                    </h3>
                </div>
                <div class="col-6 text-right">
                    <h3 class="text-danger">{{ }}</h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3 border-bottom">
                <div class="col-8 text-primary">Description</div>
                <div class="col-4 text-primary">Total</div>
            </div>
            <div class="row mb-3 border-bottom" v-for="item in timeList">
                <div class="col-8">{{ item.description }}</div>
                <div class="col-4">{{ singleRecordtotalTime(item.created_at, item.finished_at) }}</div>
            </div>
            <div class="row mb-3 border-bottom"  v-if="openRecordTime !== 'NaN:NaN:NaN'">
                <div class="col-8 text-danger" v-if="this.openTrack != null">{{ this.openTrack.description }}</div>
                <div class="col-4 text-danger">{{ openRecordTime }}</div>
            </div>
            <div class="row mb-3 border-bottom" v-if="openRecordTime !== 'NaN:NaN:NaN'">
                <div class="col-8"></div>
                <div class="col-4 text-danger text-left">
                    <button @click="stopRecord()" class="btn btn-danger border float-center">
                        <i class="fas fa-stop"></i>Stop
                    </button>
                </div>
            </div>
            <div v-if="this.status !== 'closed'">
            <div class="row align-items-center" v-if="openRecordTime === 'NaN:NaN:NaN'">
                <div class="col-7"><input type="text" class="form-control" v-model="description" /></div>
                <div class="col-3 text-left">
                    <button @click="record()" class="btn btn-primary border float-right">
                        <i class="fas fa-play"></i>Start
                    </button>
                </div>
            </div>
           </div>
        </div>
    </div>
</template>

<script>

export default {

    created() {
        this.index();
        this.openRecord();
    },
    mounted() {
        this.startTimer();
    },
    computed: {
    },
    props: ['element_id', 'element_type','status'],
    data: {
        items: [],
    },
    data() {
        return {
            timeList: [],
            openTime: {
                created_at: null,
                description: this.description,
            },
            totalTaskTime: 0,
            openRecordTime: '',
        }
    },
    methods: {
        startTimer() {
            setInterval(() => {
                const startTime = new Date(this.openTime.created_at);
                const currentTime = new Date();
                const openRecordTime = currentTime - startTime;
                let seconds = Math.floor(openRecordTime / 1000);
                const hours = Math.floor(seconds / 3600);
                seconds %= 3600;
                const minutes = Math.floor(seconds / 60);
                seconds %= 60;
                this.openRecordTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                this.totalTaskTime += openRecordTime;
            }, 1000); // Update every second
        },
        openRecord() {
            axios.get('/task/timer/open/' + this.element_id)
                .then(response => {
                    this.openTrack = response.data;
                    this.openTime.created_at = response.data.created_at;
                })
                .catch(error => {
                    console.error('Error fetching open record:', error);
                });
        },
        singleRecordtotalTime(createdAt, finishedAt) {
            const timeDifference = new Date(finishedAt.replace(' ', 'T') + 'Z').getTime() - new Date(createdAt.replace(' ', 'Z')).getTime();
            let seconds = timeDifference / 1000;
            let hours = Math.floor(seconds / 3600);
            seconds %= 3600;
            let minutes = Math.floor(seconds / 60);
            seconds %= 60;
            hours = String(hours).padStart(2, '0');
            minutes = String(minutes).padStart(2, '0');
            seconds = String(seconds).padStart(2, '0');

            return `${hours}:${minutes}:${seconds}`;
        },
        record() {
            axios.post('/task/timer/', { model_id: this.element_id, model: this.element_type, description: this.description }).then(
                response => {
                    this.openRecord = response.data;
                    location.reload();
                }
            );
        },
        stopRecord() {
            axios.post('/task/timer/stop', { id: this.element_id}).then(
                response => {
                    location.reload();
                }
            );
        },
        index() {
            axios.get('/task/timer/' + this.element_id).then(
                response => {
                    this.timeList = response.data;
                    let totalTime = 0;
                });
        },
        changeStatus(itemId) {
            axios.post('/todo/update', { id: itemId });
            this.index();
        }
    }
}

</script>
