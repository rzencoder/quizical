<template>
<div class="panel panel-default" v-show="quiz">
    {{ timerange }}
    <div>
        <div class="panel-heading results-title">
            <div>Results - {{ range }}</div>
            <div>Top {{scores.length}}</div>
        </div>
        <div :class="['panel-subheading', quiz.category]">{{quiz.quiz}}</div>
    </div>
    
    <div class="list">
        <div class="table-header">
            <div>Position</div>
            <div>Name</div>
            <div>Score</div>
            <div>Time</div>
        </div>
        <transition-group name="fly" class="list">
            <div :style="{order: scores.length - i}" :key="student.id" v-for="(student, i) in current">
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
                console.log(this.quiz);    
                this.animateResults();
            });
        }

    }
</script>

<style lang="scss">

@import '../../sass/helpers/variables';

body {
    color: $font-black;
}

.list {
    display: flex;
    flex-direction: column;
}

.student {
    display: flex;
    width: 100%;
    justify-content: space-between;
    background: $pink;
    color: $white;
    padding: 5px;
    margin: 5px 0;
    border-radius: 10px;
    text-shadow: 2px 2px $font-black;
    font-family: $font-family-title;
    font-size: 2rem;
    text-align: center;
    > div {
        width: 25%;
        text-align: center;
    }
}

.table-header {
    display: flex;
    width: 100%;
    justify-content: space-between;
    background: $light-blue;
    color: $white;
    padding: 5px;
    margin-bottom: 5px;
    text-align: center;
    text-shadow: 2px 2px $font-black;
    font-family: $font-family-title;
    font-size: 1.8rem;
    > div {
        width: 25%;
        text-align: center;
    }
}

.fly-enter-active, .fly-leave-active {
  transition: all 0.5s;
}
.fly-enter, .fly-leave-to /* .fly-leave-active below version 2.1.8 */ {
  transform: translate(-200px);
    opacity: 0;
}

.gold {
    background: gold;
    font-size: 4rem;
}

.silver {
    background: silver;
    font-size: 3.5rem;
}

.bronze {
    background: brown;
    font-size: 3rem;
}

.panel {
    background: $dark-blue;
}

.results-title {
    display: flex;
    justify-content: space-between;
}
</style>