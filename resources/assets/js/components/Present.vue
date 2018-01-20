<template>
    <div class="panel-present panel panel-default" v-show="quiz">
        {{ timerange }}
        <div>
            <div class="panel-heading results-title">
                <div>Results - {{ range }}</div>
                <div>Top {{ scores.length }}</div>
            </div>
            <div :class="['panel-subheading', quiz.category]">{{ quiz.quiz }}</div>
        </div>
        
        <div class="present-list">
            <div class="table-header">
                <div>Position</div>
                <div>Name</div>
                <div>Score</div>
                <div>Time</div>
            </div>
            <transition-group name="fly" class="present-list">
                <div :style="{ order: scores.length - i }" :key="student.id" v-for="(student, i) in current">
                    <div :class="['student', medal(i) ]">
                        <div>{{ scores.length - i }}</div>
                        <div>{{ student.name }}</div>
                        <div>{{ student.score }}</div>
                        <div>{{ student.time }}s</div>
                    </div>
                </div>
            </transition-group>
        </div>  
    </div>
</template>

<script>

    export default {     
        props: ['timerange'],
        data () {
           return {
               quiz: '',
               scores: [],
               current: []
           }
        },     
        computed: {
            range () {
                switch (this.timerange) {
                    case 60:
                        return 'Last Hour';
                        break;
                    case 1440:
                        return 'Today';
                        break;
                    case 10080:
                        return 'This Week';
                        break;
                    case 302400:
                        return 'This Month';
                        break;
                    default:
                        return 'All Time';
                        break;
                }
            }
        },
        methods: {
             medal (i) {
                switch (this.scores.length - i) {
                    case 1:
                        return 'gold'
                        break;
                     case 2:
                        return 'silver'
                        break;
                     case 3:
                        return 'bronze'
                        break;
                    default:
                        break;
                }
            },

            animateResults () {
                this.scores.forEach((score, i) => {
                    setTimeout(() => {
                        this.current.push(score);
                    }, i * 2000)
                });
            }
        },

        mounted () {
            axios.post(window.location.pathname + '/data', {'time': this.timerange}).then(response => {         
                this.quiz = response.data.quiz;
                this.scores = response.data.scores.reverse();
                this.animateResults();
            });
        }
    }

</script>

<style lang="scss">

</style>