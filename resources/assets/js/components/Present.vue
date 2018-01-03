<template>
<div v-show="quiz">
    <div>
        <div>{{quiz.category}}</div>
        <div>{{quiz.quiz}}</div>
        <div>Top {{scores.length}}</div>
    </div>
    
    <div class="list">
        <div class="student">
            <div>Position</div>
            <div>Name</div>
            <div>Score</div>
            <div>Time</div>
        </div>
        <transition-group name="fly" class="list">
            <div :style="{order: scores.length - i}" :key="student.id" v-for="(student, i) in current">
                <div class="student">
                    <div>{{ scores.length - i }}</div>
                    <div>{{ student.name }}</div>
                    <div>{{ student.score }}</div>
                    <div>{{ student.time }}</div>
                </div>
            </div>
        </transition-group>
    </div>
    
</div>
</template>

<script>

    export default {
        data () {
           return {
               quiz: '',
               scores: [],
               current: []
           }
        },

        methods: {
            animateResults () {
                this.scores.forEach((score, i) => {
                    setTimeout(() => {
                        this.current.push(score);
                    }, i * 2000)
                });
            }
        },

        mounted () {
            axios.get(window.location.pathname + '/data').then(response => {         
                  
                this.quiz = response.data.quiz;
                this.scores = response.data.scores.reverse();   
                console.log(this.quiz);    
                this.animateResults();
            });
        }

    }
</script>

<style lang="scss">

@import '../../sass/variables';

body {
    color: black;
}

.list {
    display: flex;
    flex-direction: column;
}

.student {
    display: flex;
    width: 100%;
    justify-content: space-between;
    > div {
        width: 25%;
    }
}

.fly-enter-active, .fly-leave-active {
  transition: all 0.5s;
}
.fly-enter, .fly-leave-to /* .fly-leave-active below version 2.1.8 */ {
  transform: translate(-200px);
    opacity: 0;
}

</style>