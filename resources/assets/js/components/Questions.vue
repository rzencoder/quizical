<template>
    <div>
        <div>
            <div>{{ errors }}</div>
            <div v-if="quiz" class="time-container">
                <div>Score: {{ score }}</div>
                <div>Time Left: <span>{{ formattedTime }}</span></div>
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
                    <a href="/student"><button class="btn btn-primary">Back to Dashboard</button></a>
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
               disabled: false,
               errors: ''
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
                }).catch((data) => {
                    console.log(data);
                    this.errors = 'Error: ' + data.response.data.message;
                });
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

</style>