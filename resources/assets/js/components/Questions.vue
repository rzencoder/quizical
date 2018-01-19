<template>
<div>
    <div>
        <div class="time-container">
            <div>Score: {{ score }}</div>
            <div class="time">Time Left: <span>{{ formattedTime }}</span></div>
        </div>
        
        <div v-if="quiz" class="question-container">
            <div :class="[category]" class="quiz-title">{{ quiz.quiz }}</div>
            
            <transition name="list" mode="out-in">
                <div :key="number">
                    <div class="question-title">{{ quiz.questions[number].question }}</div>
                    <div :class="['quiz-message', message]">{{ message }}</div>
                    <div class="answer-container">
                        <div class="answer" :disabled="disabled" :key="answer.id" @click="checkAnswer" v-for="answer in quiz.questions[number].answers">{{ answer.answer }}</div>  
                    </div>  
                </div>   
            </transition>     
        </div>
            
    </div>

    <transition name="fade">
        <div v-if="showModal" class="modal-wrap">
            <div class="modal-container">
                <h2>You Scored</h2>
                <h2 class="modal-score">{{ score }}/{{ quiz.questions.length }}</h2>
                <a href="/home"><button class="btn btn-primary">Back to Dashboard</button></a>
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
                        event.target.style.background = '#044e08';
                        this.message = "correct";
                    } else if (answer.answer === event.target.innerHTML && !answer.correct){
                        event.target.style.background = '#cf0505';
                        this.message = "incorrect";
                    }
                });
                setTimeout(() => {
                    this.disabled = false;
                    this.message = "";
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

@import '../../sass/helpers/variables';

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
    }

.modal-container {
    font-family: $font-family-title;
    width: 100%;
    max-width: 300px;
    height: 200px;
    color: $white;
    background: $dark-blue;
    border: 3px solid $light-blue;
    border-radius: 5px;
    z-index: 3;
    position: absolute;
    text-align: center;
    top: 100px;
    @media (max-width: 400px){
        
    }
    button {
        font-family: $font-family-base;
    }
}

.modal-score {
    font-size: 80px;
    margin-top: -10px;
}

.question-container {
    font-size: 2.5rem;
    font-family: $font-family-base;
    text-align: center;
    background: $light-grey;
    border-radius: 5px;
}

.quiz-title {
    color: $white;
    font-family: $font-family-title;
    text-transform: uppercase;
    padding: 5px;
    border-radius: 5px 5px 0 0;
    border-bottom: 2px solid $light-grey;
}

.panel {
     background: $white;
}

.question-title {
    color: $white;
    background: #444;
    padding: 5px 0;
    box-shadow: 0 2px 4px #777;
}

.answer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding-bottom: 30px;
}

.answer {
    width: 40%;
    background: $pink;
    color: $white;
    border-radius: 10px;
    margin: 10px 0;
    padding: 10px 0;
    font-family: $font-family-title;
    text-shadow: 2px 2px #222;
    box-shadow: 2px 3px 5px #777;
    cursor: pointer;
    &:hover {
        background: lighten($pink, 10%);
        color: $white;
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

.time-container {
    font-family: $font-family-title;
    font-size: 2rem;
    display: flex;
    justify-content: space-between;
}

.time {
    color: $white;
    
}

.quiz-message {
    height: 30px;
    padding: 10px;
    margin-bottom: 10px;
    text-transform: uppercase;
    font-family: $font-family-title;
}

.correct {
    color: #044e08;
}

.incorrect {
    color: #cf0505;
}

</style>