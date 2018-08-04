<template>
    <div class="p-1">
        <div class="p-2 container rounded bg-secondary">
            <div class="row align-items-center">
                <div class="col">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort By:
                    </button>
                    <div class="dropdown-menu">
                        <a v-on:click="sortDoodles('Newest First')" class="dropdown-item">Newest First</a>
                        <a v-on:click="sortDoodles('Popularity')" class="dropdown-item">Popularity</a>
                    </div>
                </div>
                <div class="col pr-4">
                    <div class="float-right">
                        <button v-on:click="setDoodleSize('standard')" class="btn-secondary border-0 mr-1"><i class="fab fa-microsoft"></i></button>
                        <button v-on:click="setDoodleSize('popularity')" class="btn-secondary border-0 mr-1"><i class="fas fa-align-center"></i></button>                 
                    </div>
                </div>               
            </div>
        </div>
        <div class="row justify-content-center">
            <div v-for="doodle in dData" v-bind:class="{ 'hide-doodle' : doodle.show === false }">
                <div class="img-frame" v-bind:style="changeDoodleSize(doodle)">
                <div class="img-props">
                    <a :href="'/doodles/' + doodle.id">
                        <img :src=doodle.source v-bind:style="changeDoodleSize(doodle)">
                    </a>
                </div>
                <div class="report-container">
                    <a href="" data-toggle="modal" v-on:click="setCurrentDoodle(doodle)" data-target="#reportModal">
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
                doodleSize: false // false changes size by popularite and true changes to standard size
            }
        },

        mounted() {
            console.log(this.doodlesData);
            this.dData = this.doodlesData;
        },

        methods: {
            sortDoodles: function(sortBy)
            {   
                if(sortBy == 'Newest First')
                {
                    this.dData = this.dData.sort((a,b)=> +new Date(b.created_at) - +new Date(a.created_at));
                }
                else
                {
                    this.dData = this.dData.sort((a,b) => (b.numberOfUpvotes - b.numberOfDownvotes) - (a.numberOfUpvotes - a.numberOfDownvotes));
                }

                return this.dData;
            },
            setDoodleSize: function(changeBy)
            {
                if(changeBy == "standard")
                {
                    this.doodleSize = true;
                }
                else
                {
                    this.doodleSize = false;
                }
                return this.dData;
            },
            changeDoodleSize: function(doodle)
            {
                let result = {};

                if(this.doodleSize == false)
                {
                    let dWidth = 0;
                    let dHeight = 0;

                    let downVotes = -(doodle.numberOfDownvotes);
                    let upVotes = doodle.numberOfUpvotes;
                    let overallVote = downVotes + upVotes;

                    dWidth = 2/3 * (this.startHeight + overallVote);
                    dHeight = 2/3 * (this.startWidth + overallVote);
                    console.log(dHeight);

                    if(dHeight > 80)
                    {
                        dHeight = 80;
                        dWidth = 2 / 3 * dHeight;
                    }
                    else if(dHeight < 30)
                    {
                        dHeight = 30;
                        dWidth = 2 / 3 * dHeight;
                    }

                    console.log(dHeight);

                    result = {width: 'auto', height: dHeight + 'vh'};
                }
                else
                {
                    result = {width: 'auto', height: this.startHeight + 'vh'};
                }
                return result;
            },
            setCurrentDoodle: function(doodle) {
                console.log('currrent doodle is ' + doodle.id);
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