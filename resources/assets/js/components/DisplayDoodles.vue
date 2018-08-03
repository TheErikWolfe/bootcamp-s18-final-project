<template>
    <div class="p-1">
        <div class="p-2 container rounded bg-secondary">
            <div class="row align-items-center">
                <div class="col">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By:
                    </button>
                    <div class="dropdown-menu">
                        <a v-on:click="sortBy = true" class="dropdown-item" href="">Newest First</a>
                        <a v-on:click="sortBy = false" class="dropdown-item" href="">Popularity</a>
                    </div>
                </div>
                <div class="col pr-4">
                    <div class="float-right">
                        <button v-on:click="doodleSize = true" class="btn-secondary border-0 mr-1"><i class="fab fa-microsoft"></i></button>
                        <button v-on:click="doodleSize = false" class="btn-secondary border-0 mr-1"><i class="fas fa-align-center"></i></button>                 
                    </div>
                </div>               
            </div>
        </div>
        <div class="row justify-content-center">
            <div v-for="doodle in dData" v-bind="setCurrentDoodle(doodle)" v-bind:class="{ 'hide-doodle' : doodle.show === false }">
                <div class="img-frame" v-bind:style="changeDoodleSize(doodle)">
                <div class="img-props">
                    <a :href="'/doodles/' + doodle.id">
                        <img :src=doodle.source v-bind:style="changeDoodleSize(doodle)">
                    </a>
                </div>
                <div class="report-container">
                    <a href="" data-toggle="modal" data-target="#reportModal">
                        Report
                    </a>
                </div>
                <!-- Modal -->
                <div class="arrow-container">
                    <div v-on:click="onVote(doodle, 1)" class="arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : doodle.userVote === 1 }"></i></div>
                    <div v-on:click="onVote(doodle, -1)" class="arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : doodle.userVote === -1 }"></i></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportModalLabel">Please describe why you are reporting this image.</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="reportInput" v-model="reportString" placeholder="">
                                    <small>After reporting, you won't see this doodle anymore.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="createReport()">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                dData: null,
                upvote: 1,
                downvote: -1,
                novote: 0,
                startHeight: 60,
                startWidth: 90,
                dWidth: 0,
                dHeight: 0,
                reportString: '',
                currentDoodle: null,
                doodleSize: false, //true is same size, false is by popularity sizes
                sortBy: true //true is newest first, false is by popularite
            }
        },

        mounted() {
            console.log(this.doodlesData);
            this.dData = this.doodlesData;
        },

        computed: {  
        },

        methods: {
            changeDoodleSize(doodle)
            {
                if(this.doodleSize = false)
                {
                    let downVotes = -(doodle.numberOfDownvotes);
                    let upVotes = doodle.numberOfUpvotes;
                    let overallVote = downVotes + upVotes;

                    this.dWidth = 2/3 * (this.startHeight + overallVote);
                    this.dHeight = 2/3 * (this.startWidth + overallVote);

                    if(this.dHeight > 80)
                    {
                        this.dHeight = 80;
                        this.dWidth = 2 / 3 * dHeight;
                    }
                    else if(this.dHeight < 30)
                    {
                        this.dHeight = 30;
                        this.dWidth = 2 / 3 * dHeight;
                    }

                    // console.log(this.dWidth + ', ' + this.dHeight);
                    this.$forceUpdate();
                    return {width: 'auto', height: this.dHeight + 'vh'};
                }
                else
                {
                    return {width: 'auto', height: this.startHeight + 'vh'};
                }
            },
            setCurrentDoodle: function(doodle) {
                this.currentDoodle = doodle;
            },
            onVote:function (doodle, userVote) 
            {
                if(doodle.userVote == null)
                {
                    this.createVote(doodle.id, userVote);
                    doodle.userVote = userVote;
                }
                else if(doodle.userVote == userVote)
                {
                    this.saveVote(doodle.id, this.novote);
                    // set it to a number that isn't 1, -1, or 0 so it doesn't create another vote table.
                    doodle.userVote = 0;
                }
                else {
                    this.saveVote(doodle.id, userVote);
                    doodle.userVote = userVote;
                }
                console.log(doodle.userVote);
            },
            createVote: function (doodleId, userVote)
            {
                console.log("Made it to createVote");
                axios.post('/votes', {
                    doodle_id: doodleId,
                    vote: userVote
                });
            },
            saveVote: function (id, userVote)
            {
                console.log("Made it to saveVote");
                axios.patch('/votes/' + id.toString(), {
                    vote: userVote
                });
            },
            createReport: function ()
            {
                this.currentDoodle.show = false;
                axios.post('/reports', {
                    doodle_id: this.currentDoodle.id,
                    report: this.reportString
                });
                this.reportString = '';
                return this.currentDoodle;
            },
            doodleOnClick: function () {
                console.log("Made it to onClick");
                axios.get('/doodles/' + id.toString(), {
                    
                }).then(function (response) {
                    window.location = response.data.redirect;
                });
            }
        }
    }
</script>