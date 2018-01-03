<template>
<div>
    <div>
        <div class="time">Time Left: <span>{{ formattedTime }}</span></div>
        <div v-if="quiz" class="question-container">
            <div :class="[category]" class="quiz-title">{{ quiz.quiz }}</div>
            <transition name="list" mode="out-in">
                <div :key="number">
                    <div class="question-title">{{ quiz.questions[number].question }}</div>
                    <div class="answer-container">
                        <div class="answer" :disabled="disabled" :key="answer.id" @click="checkAnswer" v-for="answer in quiz.questions[number].answers">{{ answer.answer }}</div>  
                    </div>  
                </div>   
            </transition>     
        </div>
        <div>{{ message }}</div>    
    </div>

    <transition name="fade">
        <div v-if="showModal" class="modal-wrap">
            <div class="modal-container">
                <h2 >You Scored: {{ score }}</h2>
                <a href="/quizzes"><button class="btn btn-primary">Back to Quizzes</button></a>
            </div>
        </div>
    </transition>
</div>
</template>

<script>

    export default {
        data () {
           return {
               quiz: '',
               number: 0,
               score: 0,
               time: 0,
               date: 0,
               message: '',
               showModal: false,
               category: '',
               disabled: false
           }
        },

        computed: {

            formattedTime () {
                return (this.date - this.time) % 60;
            }

        },


        methods: {

            startTimer () {
                this.date = Math.trunc((new Date()).getTime() / 1000) + 60;
                this.interval = setInterval(() => {
                    this.time = Math.trunc((new Date()).getTime() / 1000);
                    if (this.time >= this.date) {
                        this.endQuiz();
                    }
                },1000);
            },

            checkAnswer (event) {
                this.disabled = true;
                this.quiz.questions[this.number].answers.forEach(answer => {
                    if(answer.answer === event.target.innerHTML && answer.correct){
                        this.score++;
                        event.target.style.background = 'green';
                    } else if (answer.answer === event.target.innerHTML && !answer.correct){
                        event.target.style.background = 'red';
                    }
                });
                setTimeout(() => {
                    this.disabled = false;
                    if (this.number + 1 >= this.quiz.questions.length) {
                        this.endQuiz();
                    } else {
                        this.number++;
                    }
                }, 1000);
            },

            endQuiz () {
                window.clearInterval(this.interval);
                this.disabled = true;
                axios.post(window.location.pathname + '/results', {
                    score: this.score, 
                    time: 60 - (this.date - this.time)
                }).then(response => {
                    this.displayResult();
                })
            },

            displayResult () {          
                var overlay = document.createElement("div");
                overlay.classList.add('overlay');
                document.body.appendChild(overlay);
                this.showModal = true;
            },

            shuffle (a) {
                for (let i = a.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [a[i], a[j]] = [a[j], a[i]];
                }
                return a;
            }
        },

        mounted () {
            axios.get(window.location.pathname + '/questions').then(response => {         
                this.category = response.data.quiz.category.toLowerCase();
                let quiz = response.data.quiz;
                quiz.questions.forEach(question => {
                   this.shuffle(question.answers)
                });
                this.quiz = quiz;
                this.startTimer();           
            });
        }

    }
</script>

<style lang="scss">

@import '../../sass/variables';

    body {
  
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

    .modal-wrap {
        display: flex;
        justify-content: center;
        margin: -200px auto;
    }

.modal-container {
    width: 300px;
    height: 200px;
    color: #fff;
    background: #042a2b;
    border: 5px solid #e14807;
    border-radius: 5px;
    z-index: 3;
    position: relative;
    text-align: center;
}

.history {
    background: green;
    width: 100%;
}

.music {
    background: red;
}

.question-container {
    font-size: 2.5rem;
    font-family: $font-family-sans-serif;
    text-align: center;
    background: #ddd;
}

.quiz-title {
    color: #fff;
    font-family: $font-family-cursive;
    text-transform: uppercase;
    padding: 5px;
    border-radius: 5px;

}

.panel {
     background: #fff;
}

.question-title {
    color: #fff;
    background: #666;
    padding: 10px 0;
}

.answer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.answer {
    width: 40%;
    background: #e14807;
    color: white;
    border-radius: 10px;
    margin: 10px 0;
    cursor: pointer;
    &:hover {
        background: lighten(#e14807 , 10%);
    }
    @media (max-width: 500px) {
        width: 95%;
    }
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 1s ease-out;
  opacity: 1;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}




.list-enter-active, .list-leave-active {
  transition: all 0.5s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
  opacity: 0;

}

.time {
    color: white;
}

</style>