import './bootstrap';


import { Bar } from 'vue-chartjs'

import { createApp } from 'vue'
import Counter from './components/Counter.vue'
import FullCalendar from './components/plugins/FullCalendar.vue'
//import Graph from './components/Grafica.vue'
import Doughnut from './components/plugins/Doughnut.vue'
import ShowComments from './components/ShowComments.vue'
import NewComment from './components/NewComment.vue'
import ToDo from './components/to-do/ToDo.vue'
import ToDoGeneral from './components/to-do/ToDoGeneral.vue'
import TaskStatus from './components/tasks/TaskStatus.vue'
import ProjectTaskStatusList from './components/tasks/ProjectTaskStatusList.vue'
import TaskIndex from './components/tasks/TaskIndex.vue'
import Files from './components/projects/Files.vue'
import TimeTrackerActive from './components/time-tracker/TimeTrackerActive.vue'
import TimeTrackerButton from './components/time-tracker/TimeTrackerButton.vue'




const app = createApp()
app.component('counter', Counter)
app.component('calendar', FullCalendar)
//app.component('graph', Graph)
app.component('graph', Doughnut)
app.component('show-comments', ShowComments)
app.component('new-comment', NewComment)
app.component('time-tracker-active', TimeTrackerActive)
app.component('time-tracker-button', TimeTrackerButton)
app.component('to-do', ToDo)
app.component('task-status', TaskStatus)
app.component('project-task-status-list', ProjectTaskStatusList)
app.component('task-index', TaskIndex)
app.component('to-do-general', ToDoGeneral)
app.component('files', Files)





app.mount('#app')

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
