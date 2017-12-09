<template>
    <div class="container">   
        <div v-bind="collection">
            <div class="panel-heading">{{collection.collection}}</div>
            <div>{{ collection.questions[number].question }}</div>
            <div :key="answer.id" @click="checkAnswer" v-for="answer in collection.questions[number].answers">{{ answer.answer }}</div>            
        </div>
        <div v-bind="message">{{ message }}</div>
        <modal></modal>
    </div>
</template>

<script>
    export default {
        data () {
           return {
               collection: '',
               number: 0,
               score: 0,
               message: ''
           }
        },

        methods: {
            checkAnswer (event) {
                console.log(event);
                this.collection.questions[this.number].answers.forEach(answer => {
                    if(answer.answer === event.target.innerHTML && answer.correct){
                        this.score++;
                    }
                });
                if (this.number + 1 >= this.collection.questions.length) {
                    this.endQuiz();
                } else {
                     this.number++;
                }
               
                console.log(this.score);
            },

            endQuiz () {
                console.log('End')
                axios.post(window.location.pathname + '/results', {
                    score: this.score
                }).then(response => {
                    console.log(response)
                })
            }
        },

        mounted() {
            console.log('Component mounted.')
            axios.get(window.location.pathname + '/questions').then((response)=>{
    
                this.collection = response.data.collection;
                console.log(this.collection);
            })
        }

    }
</script>

<style lang="scss">

    body {
        background: orange;
    }

</style>