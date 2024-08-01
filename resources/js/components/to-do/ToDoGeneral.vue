<template>
    <div class="card">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                To Do List
            </h3>
            <div class="card-tools">

            </div>
        </div>
        <div class="card-body">
            <div class="row border-bottom">
                <div class="col-3 mb-2"><span class="text-bold">Project</span></div>
                <div class="col-3 mb-2"><span class="text-bold">Task</span></div>
                <div class="col-6 mb-2"><span class="text-bold">To Do</span></div>
            </div>
         <div class="row border border-top border-bottom" v-for="item in this.data">
            <div class="col-3 align-items-center d-flex pl-4">
                <a :href= "'/project/' + item.project_id">{{ item.project_name }}</a>
            </div>
            <div class="col-3 align-items-center d-flex pl-2">
                 <a :href= "'/task/' + item.element_id">{{ item.task_name }}</a>
            </div>
            <div class="col-6">
                <ul class="todo-list ui-sortable" data-widget="todo-list">
                     <li>
                        <div class="icheck-primary d-inline ml-2">
                            <input type="checkbox" value="" name="todo1" :id="item.id" :checked="item.status"
                                @click="changeStatus(item.id)">
                            <label for="todoCheck1"></label>
                        </div>
                        <span class="text">{{ item.value }}</span>
                            <div class="tools">
                                <i class="fas fa-trash" @click="deleteItem(item.id)"></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    created() {
        this.index();
    },

    props: ['element_id', 'element', 'itemId'],
    
    data: {
        items: []
    },
    data() {
        return {
            todo: '',
            data: ''
        }
    },
    methods: {
        index() {
            axios.get('/todo/general/').then(
                response => {
                    this.data = response.data
                });
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
