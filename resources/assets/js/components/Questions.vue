<template>
    <div class="container">
        <div v-bind="collection">{{collection.collection}}
            <div>{{ collection.questions[number].question }}</div>
                <div :key="answer.id" @click="checkAnswer" v-for="answer in collection.questions[number].answers">{{ answer.answer }}</div>            
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
           }
        },

        methods: {
            checkAnswer (event) {
                console.log(event.target)
                this.number++;
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