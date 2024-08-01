<template>
    <Doughnut :data="Data" :options="Options" />
</template>

  <script>

    import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
    import { Doughnut } from 'vue-chartjs'

    ChartJS.register(ArcElement, Tooltip, Legend)

    export default {
        name: 'DoughnutChart',
        props: {
            status: {
                type: Array,
                required: true
            },
            colors: {
                type: Array,
                required: true
            }
        },

        components: {
            Doughnut
        },
        data() {
        return {
                Data: {
                labels: Object.keys(this.status),
                datasets: [ {
                    data: Object.values(this.status),
                    backgroundColor: this.colors,
                // backgroundColor: ['#ff0000','#ffa700','#fff400','#a3ff00','#2cba00'],
                // backgroundColor: ['green', 'red'],
                } ]
                },
                Options: {
                responsive: true
                }
            }

        },
    computed: {
        stageCount() {
        return this.status.count;
        }
    }
    }
  </script>
