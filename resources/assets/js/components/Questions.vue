<template>
<div>
    <div class="container">   
        <div>
            <div class="panel-heading">{{collection.collection}}</div>
            <div>{{ collection.questions[number].question }}</div>
            <div :key="answer.id" @click="checkAnswer" v-for="answer in collection.questions[number].answers">{{ answer.answer }}</div>            
        </div>
        <div>{{ message }}</div>
        
    </div>
    <div :class="{'display': !showModal}">
        <div class="modal-container">
            <h2 >You Scored: {{ score }}</h2>
            <a href="/quizzes"><button class="btn btn-primary">Back to Quizzes</button></a>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data () {
           return {
               collection: '',
               number: 0,
               score: 0,
               time: 0,
               message: '',
               showModal: false
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

                axios.post(window.location.pathname + '/results', {
                    score: this.score, 
                    time: this.time
                }).then(response => {
                    console.log(response);
                    this.displayResult();
                })
            },

            displayResult () {          
                var overlay = document.createElement("div");
                overlay.classList.add('overlay');
                document.body.appendChild(overlay);
                this.showModal = true;
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

    .overlay {
        position: absolute;
        top:0;
        background: #000;
        opacity: 0.5;
        width: 100%;
        height: 100%;
    }

    .display {
        display: none;
    }

.modal-container {
    width: 300px;
    height: 200px;
    background: #fff;
    border: 3px solid blue;
    z-index: 3;
    position: relative;
}

</style>