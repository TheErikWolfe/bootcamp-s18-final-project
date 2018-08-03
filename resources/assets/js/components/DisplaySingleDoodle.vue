<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="single-doodle-bkgd text-center mt-4">
                <div class="card-header bg-dark p-0">
                    <div class="row p-0">
                        <div class="col pl-5 p-0">
                            <div class="row">
                                <div v-on:click="onVote(1)" class="col-1 m-0 p-0 arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : userVote === 1 }"></i></div>
                                <!-- <div id="doodle-points" class="col ml-3 text-success" v-bind:class="whichColor">{{ doodleData.numberOfUpvotes - doodleData.numberOfDownvotes }}</div> -->
                                <div v-on:click="onVote(-1)" class="col-1 m-0 p-0 arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : userVote === -1 }"></i></div>

                            </div>    
                        </div>                      
                        <div class="col">
                            <a v-bind:class="{ 'hidden' : doodleData.previous === null }" :href="'/doodles/' + doodleData.previous" class="btn mt-4 btn-secondary shadow"><</a>
                            <a v-bind:class="{ 'hidden' : doodleData.next === null }" :href="'/doodles/' + doodleData.next" class="btn mt-4 btn-secondary shadow">Next ></a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="img-props m-2">
                        <img :src=imgSource>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="comment-form">
                <div class="card-body p-0 m-0 rounded-0">
                    <textarea name="user-comment" v-model="commentString" placeholder="Write a comment" row="3" class="form-control text-dark w-100 h-100" id=""></textarea>
                </div>
                <div class="card-footer rounded-0 p-0 m-0">
                    <button v-on:click="postComment()" class="m-0 float-right btn btn-dark">Post</button>
                </div>
            </div>

            <div class="mt-3 d-flex" v-for="comment in comments">
                <div class="comment-form">
                    <div class="card-header text-light bg-dark">
                        <div class="row">
                            <div class="col">
                                {{ comment.commenter_id }}
                            </div>
                            <div class="col text-align-right">
                                commented at: {{ comment.created_at }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-light bg-secondary">
                        <strong>{{ comment.comment_string }}</strong>
                    </div>
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
                comments: [],
                upVotes: 0,
                downVotes: 0,
                noVote: 0,
                whichColor: '',
                commentString: ''
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
            this.comments = this.doodle.comments;
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
            postComment: function ()
            {
                axios.post('/comments', {
                    comment: this.commentString,
                    doodle_id: this.doodleData.id
                });
                this.comments.unshift({comment_string: this.commentString, commenter_id: this.doodle.id, created_at: 'Now'})
                this.commentString = '';
                
            },
        }

    }
</script>