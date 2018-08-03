<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="single-doodle-bkgd text-center mt-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col">

                        </div>
                        <div class="col">
                            <a v-bind:class="{ 'hidden' : doodleData.previous === null }" :href="'/doodles/' + doodleData.previous" class="btn btn-dark"><</a>
                            <a v-bind:class="{ 'hidden' : doodleData.next === null }" :href="'/doodles/' + doodleData.next" class="btn btn-secondary shadow">Next ></a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="img-props m-0">
                        <img :src=imgSource>
                    </div>
                </div>
                <div class="card-footer d-flex bg-info text-left">
                    <div>
                        <div v-on:click="onVote(1)" class="arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : userVote === 1 }"></i></div>
                        <div id="doodle-points" class="ml-3 text-success" v-bind:class="whichColor">{{ doodleData.numberOfUpvotes - doodleData.numberOfDownvotes }}</div>
                    </div>    
                    <div v-on:click="onVote(-1)" class="arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : userVote === -1 }"></i></div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="comment-form">
                <div class="card-body">
                    <textarea name="user-comment" placeholder="Write a comment" id=""></textarea>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark"></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['doodleData'],

        data () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                doodle: null,
                imgSource: '',
                userVote: 0,
                upVotes: 0,
                downVotes: 0,
                noVote: 0,
                whichColor: ''
            }
        },
        mounted() {
            console.log(this.doodleData);
            this.doodle = this.doodleData;
            this.userVote = this.doodle.userVote;
            this.imgSource = this.doodle.source;
            this.upVotes = this.doodle.numberOfUpvotes;
            this.downVotes = this.doodle.numberOfDownvotes;
            this.userVote = this.doodle.userVote;
        },
        computed: {
            votesColor: function () {
                if(this.upVotes - this.downVotes > 0)
                {
                    this.whichColor = 'text-success';
                }
                else
                {
                    this.whichColor = 'text-danger';
                }
                
            },
        },
        methods: {
            onVote: function (newVote) 
            {
                if(this.userVote == null)
                {
                    this.createVote(newVote);
                    this.userVote = newVote;
                }
                else if(this.userVote == newVote)
                {
                    this.saveVote(this.noVote);
                    // set it to a number that isn't 1, -1, or 0 so it doesn't create another vote table.
                    this.userVote = 0;
                }
                else {
                    this.saveVote(newVote);
                    this.userVote = newVote;
                }
                console.log(this.userVote);
            },
            createVote: function (userVote)
            {
                console.log("Made it to createVote");
                axios.post('/votes', {
                    doodle_id: this.doodle.id,
                    vote: userVote
                });
            },
            saveVote: function (userVote)
            {
                console.log("Made it to saveVote");
                axios.patch('/votes/' + this.doodle.id.toString(), {
                    vote: userVote
                });
            },
        }

    }
</script>