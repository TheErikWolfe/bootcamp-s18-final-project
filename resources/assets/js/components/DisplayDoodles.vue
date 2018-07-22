<template>
    <div>
        <div v-for="doodle in doodlesData" class="img-frame">
            <div class="img-props" v-on:click="showSingleDoodle(doodle.id)" type="submit">
                <img :src=doodle.source alt="">
            </div>
            <div class="arrow-container">
                <div v-on:click="upvoteImg(doodle.id)" class="arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : isUpvoted }"></i></div>
                <div v-on:click="downvoteImg(doodle.id)" class="arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : isDownvoted }"></i></div>
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
                isDownvoted: false,
                changeUpvotes: 0,
                changeDownvotes: 0
            }
        },

        mounted() {
            console.log(this.doodlesData)
        },

        computed: {
            
        },

        methods: {
            upvoteImg: function (id) 
            {
                if(this.isDownvote == true)
                {
                    this.changeDownvotes = -1;
                }

                this.isUpvoted = !this.isUpvoted;
                this.isDownvoted = false;

                if(this.isUpvoted == true)
                {
                    this.changeUpvotes = 1;
                }
                else 
                {
                    this.changeUpvotes = -1;
                }

                this.saveVote(id);
            },
            downvoteImg: function (id) 
            {
                if(this.isUpvote == true)
                {
                    this.changeUpvotes = -1;
                }

                this.isUpvoted = false;
                this.isDownvoted = !this.isDownvoted;

                if(this.isDownvoted == true)
                {
                    this.changeDownvotes = 1;
                }
                else 
                {
                    this.changeDownvotes = -1;
                }

                this.saveVote(id);
            },
            saveVote: function (id)
            {
                axios.post('/doodles/vote/' + id, {
                    upvote : this.changeUpvotes,
                    downvote : this.changeDownvotes
                })
            },
            showSingleDoodle: function (id)
            {
                console.log("Showing Doodle of " + id);
            }
        }
    }
</script>