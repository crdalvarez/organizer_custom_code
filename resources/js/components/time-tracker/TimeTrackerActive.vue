<template>
   <div class="col-12">
        <div class="row">
            <div class="col-1 text-right mt-3">
                <h5 class="text-primary">Track Time:</h5>
            </div>
            <div class="col-11">
                <div class="form-inline">
                    <div class="form-group mr-2 ml-3 col-4">
                        <p v-for="items in this.projectData">echco</p>
                        <select name="projects" class="w-100 bg-white border rounded form-control-lg"
                            aria-label=".form-select-lg example">
                              <option></option>
                            <option v-for="project in this.projectData" :key="task.id">{{ project.name}}</option>
                        </select>
                    </div>
                    <div class="form-group mr-2 ml-3 col-5">
                        <select name="tasks" class="w-100 bg-white border rounded form-control-lg"
                            aria-label=".form-select-lg example">
                            <option v-for="task in tasks" :key="task.id">{{ task.name }}</option>
                        </select>
                    </div>
                    <div class="form-group mr-2ml-3 col-1">
                        <button type="submit" class="btn btn-primary text-lg" @click="getProjects()">START</button>
                    </div>
                    <div class="form-group mr-2 mt-2 col-1 text-left">
                        <h1 class="text-danger border rounded pr-2 pl-2">00:00</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {

    created() {
        this.getProjects();
        alert(this.projectData);
    },
    data: {
        items: []
    },
    data() {
        return {
            projectData: []
        }
    },
    methods: {
        getProjects() {
            axios.get('/track/projects').then(
                response => {
                    this.projectData = response.data
                },
            )
        },
    }
}
</script>
