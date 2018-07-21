<template>
    <div>
        <div v-for="doodle in doodlesData" class="img-frame">
            <div class="img-props">
                <img :src=doodle.source alt="">
            </div>
            <div class="arrow-container">
                <div v-on:click="upvoteImg" class="arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : isUpvoted }"></i></div>
                <div v-on:click="downvoteImg" class="arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : isDownvoted }"></i></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['doodlesData'],

        data () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                isUpvoted: false,
                isDownvoted: false
            }
        },

        mounted() {
            
        },

        computed: {

        },

        methods: {
            upvoteImg: function () 
            {
                this.isUpvoted = !this.isUpvoted;
                this.isDownvoted = false;
                saveVote();
            },
            downvoteImg: function () 
            {
                this.isUpvoted = false;
                this.isDownvoted = !this.isDownvoted;
                saveVote();
            }
        }
    }
</script>