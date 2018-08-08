<template>
    <div class="container text-center p-2">
        <div class="row justify-content-center">
            <div class="single-doodle-bkgd text-center">
                <div class="card bg-dark p-0">
                    <div class="row p-0">
                        <div class="col pl-5">
                            <div class="row">
                                <div v-on:click="onVote(1)" class="col-1 m-0 p-0 single-doodle-arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : userVote === 1 }"></i></div>
                                <div id="doodle-points" class="col p-0 m-0 mt-3 text-success">{{ doodle.numberOfUpvotes }}</div>
                                <div v-on:click="onVote(-1)" class="col-1 m-0 p-0 single-doodle-arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : userVote === -1 }"></i></div>
                                <div id="doodle-points" class="col p-0 m-0 mt-3 text-danger">{{ doodle.numberOfDownvotes }}</div>
                            </div>    
                        </div>                      
                        <div class="col">
                            <a v-bind:class="{ 'hidden' : doodleData.previous === null }" :href="'/doodles/' + doodleData.previous" class="btn my-3 btn-secondary shadow">< Back</a>
                            <a v-bind:class="{ 'hidden' : doodleData.next === null }" :href="'/doodles/' + doodleData.next" class="btn my-3 btn-secondary shadow">Next ></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-doodle-img-frame m-3" v-bind:style="currentFrameColor">
                        <div class="single-doodle-img-props m-2">
                            <img :src=imgSource>
                            <img class="single-doodle-signature-props" :src="doodle.signature.source">
                        </div>
                    </div>
        <div class="row justify-content-center mt-3">
            <div class="comment-form">
                <div class="card-body p-0 m-0 rounded-0">
                    <textarea name="user-comment" v-model="commentString" placeholder="Write a comment" row="3" class="form-control rounded-0 text-dark w-100 h-100" id=""></textarea>
                </div>
                <div class="card-footer rounded-0 p-0 m-0">
                    <button v-on:click="postComment()" class="m-0 w-100 btn btn-dark">Post</button>
                </div>
            </div>

            <div class="mt-3 d-flex" v-for="comment in comments">
                <div class="comment-form">
                    <div class="card-header text-light bg-dark">
                        <div class="row">
                            <div class="col">
                                Anonymous
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
                commentString: '',
                currentFrameColor: {}
            }
        },
        created() {
            this.doodle = this.doodleData;
            this.userVote = this.doodle.userVote;
            this.imgSource = this.doodle.source;
            this.upVotes = this.doodle.numberOfUpvotes;
            this.downVotes = this.doodle.numberOfDownvotes;
            this.userVote = this.doodle.userVote;
            this.comments = this.doodle.comments;
            this.frameColor();
        },
        methods: {
            changeVote: function (newVote, adder)
            {
                if(newVote == 1)
                {
                    this.doodle.numberOfUpvotes +=  adder;
                }
                else if(newVote == -1)
                {
                    this.doodle.numberOfDownvotes += adder;
                }
            },
            /*
             * This function should:
             * - take the new user vote and either:
             * -- replace the old
             * -- create a new one
             * -- unset the old vote
             */
            onVote: function (newVote) {
                this.changeVote(this.userVote, -1);
                if(this.userVote == null) {
                    this.createVote(newVote);
                    this.userVote = newVote;
                    this.changeVote(newVote, 1);
                }
                else if(this.userVote == newVote) {
                    this.saveVote(this.noVote);
                    // set it to a number that isn't 1, -1, or 0 so it doesn't create another vote table.
                    this.userVote = 0;
                }
                else {
                    this.saveVote(newVote);
                    this.userVote = newVote;
                    this.changeVote(newVote, 1);
                }
                this.frameColor();
            },
            /*
             * This function should:
             * - create a new vote in the database using axios
             */
            createVote: function (userVote) {
                axios.post('/votes', {
                    doodle_id: this.doodle.id,
                    vote: userVote
                });
            },
            /*
             * This function should:
             * - save a new vote variable to the existing table in the database using axios
             */
            saveVote: function (userVote) {
                axios.patch('/votes/' + this.doodle.id.toString(), {
                    vote: userVote
                });
            },
            /*
             * This function should:
             * - change the color of the border around the image based on:
             * -- If the users doodle vote is an upvote or a downvote. If there is no vote then it will automatially go back to white.
             */
            frameColor: function() {
                let result = {};
                if(this.userVote == -1) {
                    result = {
                    'border-bottom-color' : '#ffb4b4',
                    'border-left-color' : '#ff9a9a',
                    'border-right-color' : '#ff9a9a',
                    'border-top-color' : '#ff8181'}
                }
                else if(this.userVote == 1) {
                    result = {
                    'border-bottom-color' : '#e8fbe8',
                    'border-left-color' : '#d2f8d2',
                    'border-right-color' : '#d2f8d2',
                    'border-top-color' : '#bcf5bc'}
                }
                else {
                    result = {
                    'border-bottom-color' : '#fff',
                    'border-left-color' : '#eee',
                    'border-right-color' : '#eee',
                    'border-top-color' : '#ddd'}
                }
                this.currentFrameColor = result;
            },
            /*
             * This function should:
             * - save a new comment string to the database using axios and then post a javascript instance of that comment.
             */
            postComment: function () {
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