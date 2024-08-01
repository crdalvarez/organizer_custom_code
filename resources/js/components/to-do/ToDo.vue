<template>
    <div class="card">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                To Do List
            </h3>
        </div>
        <div class="card-body">
            <ul class="todo-list ui-sortable" data-widget="todo-list">
                <li v-for="item in this.data">
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo1" :id="item.id"  :checked="item.status" @click="changeStatus(item.id)" >
                        <label for="todoCheck1"></label>
                    </div>
                    <span class="text">{{item.value}}</span>
                    <div class="tools">
                        <i class="fas fa-trash"  @click="deleteItem(item.id)"></i>
                    </div>
                </li>
            </ul>
        </div>
        <div class="card-footer clearfix">
            <div class="row" v-if="this.status!=='closed'" >
                <div class="col-8">
                    <input id="todo" class="form-control" type="text"  v-model="todo" required autofocus />
                </div>
                <div class="col-4">
                    <button @click="addToDo" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add
                        item</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    created(){
            this.index();
        },
    props: ['element_id', 'element', 'itemId', 'status'],
    data: {
        items: []
    },
    data() {
        return {
            todo: '',
            data:''
        }
    },
    methods: {
        index(){
            axios.get('/todo/index/' + this.element + '/' + this.element_id).then(
                response=>{
                this.data = response.data
            });
        },
        addToDo() {
            const data = {
                todo: this.todo,
                element: this.element,
                element_id: this.element_id,
            };
            axios.post('/todo', { value: todo.value, element: this.element, element_id: this.element_id });
            this.index();
            this.todo = '';
        },
        deleteItem(itemId) {
            axios.post('/todo/delete', {id: itemId});
            this.index();
        },
        changeStatus(itemId){
            axios.post('/todo/update', {id: itemId});
            this.index();
        }
    }
}

</script>
