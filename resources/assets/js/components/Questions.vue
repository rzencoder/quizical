<template>
<div>
    <div>
        <div class="question-container">
            <div :class="[category]" class="quiz-title">{{quiz.quiz}}</div>
            <transition-group tag="div" class="slide-group" 
                    
                    @before-leave="sgBeforeLeave">
                <div :key="number">
            <div class="question-title">{{ quiz.questions[number].question }}</div>
            <div class="answer-container">
                <div class="answer" :key="answer.id" @click="checkAnswer" v-for="answer in shuffle(quiz.questions[number].answers)">{{ answer.answer }}</div>  
            </div>  
            </div>   
            </transition-group>     
        </div>
        <div>{{ message }}</div>
        
    </div>
    <transition name="fade">
    <div v-if="showModal">
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
               message: '',
               showModal: false,
               category: ''
           }
        },

        methods: {
            sgBeforeLeave(el){
                
                el.style.opacity = 0;
            },
            checkAnswer (event) {
                console.log(event);
                this.quiz.questions[this.number].answers.forEach(answer => {
                    if(answer.answer === event.target.innerHTML && answer.correct){
                        this.score++;
                    }
                });
                setTimeout(()=>{
                    if (this.number + 1 >= this.quiz.questions.length) {
                    this.endQuiz();
                } else {
                     this.number++;
                }
                }, 2000);
                
               
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
            },

            shuffle (a) {
                for (let i = a.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [a[i], a[j]] = [a[j], a[i]];
                }
                return a;
            }
        },

        mounted() {
            console.log('Component mounted.')
            axios.get(window.location.pathname + '/questions').then((response)=>{
    
                this.quiz = response.data.quiz;
                this.category = response.data.quiz.category.toLowerCase();
                console.log(this.quiz);
            })
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

.modal-container {
    width: 300px;
    height: 200px;
    background: #fff;
    border: 3px solid blue;
    z-index: 3;
    position: relative;
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
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 2s ease-out;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}


.in {
    transform: translate(-200px);
}

.out {
    opacity: 0;
}

</style>