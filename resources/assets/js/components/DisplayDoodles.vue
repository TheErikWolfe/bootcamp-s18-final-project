<template>
    <div class="p-2">
        <div class="p-2 container rounded bg-dark">
            <div class="row align-items-center">
                <div class="col">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ 'Sort By: ' + sortBy }}
                    </button>
                    <div class="dropdown-menu">
                        <a v-on:click="sortDoodles('Newest First')" class="dropdown-item">Newest First</a>
                        <a v-on:click="sortDoodles('Popularity')" class="dropdown-item">Popularity</a>
                    </div>
                    
                </div>
                
                <div class="col pr-4">
                    <div class="float-right text-light">
                        Change Doodle Sizes:
                        <button v-on:click="setDoodleSize('standard')" class="btn-secondary border-0 mr-1"><i class="fab fa-microsoft"></i></button>
                        <button v-on:click="setDoodleSize('popularity')" class="btn-secondary border-0 mr-1"><i class="fas fa-align-center"></i></button>                 
                    </div>
                </div>               
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div v-for="doodle in dData" v-bind:class="{ 'hide-doodle' : doodle.show === false }">
                <div class="img-frame" v-bind:style="changeDoodleSize(doodle)">
                    <div class="img-props">
                        <a :href="'/doodles/' + doodle.id">
                            <img :src=doodle.source v-bind:style="changeDoodleSize(doodle)">
                            <img class="signature-props" :src="doodle.signature.source">
                        </a>
                    </div>
                    <div class="report-container">
                        <a href="" data-toggle="modal" v-on:click="setCurrentDoodle(doodle)" data-target="#reportModal">
                            Report
                        </a>
                    </div>
                    <div v-on:click="onVote(doodle, 1)" class="arrow bg-transparent fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : doodle.userVote === 1 }"></div>
                    <div v-on:click="onVote(doodle, -1)" class="arrow bg-transparent fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : doodle.userVote === -1 }"></div>
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
                startHeight: 75,
                startWidth: 90,
                reportString: '',
                currentDoodle: null,
                doodleSize: false, // false changes size by popularite and true changes to standard size
                sortBy: 'Newest First'
            }
        },

        mounted() {
            this.dData = this.doodlesData;
        },

        methods: {
            /*
             * This function should:
             * - sort images by popularity or newest by
             * -- comparing dates or
             * -- comparing upvotes less downvotes
             * - return the doodle data to make the changes take effect
             */
            sortDoodles: function(sortBy) {   
                if(sortBy == 'Newest First') {
                    this.dData = this.dData.sort((a,b)=> +new Date(b.created_at) - +new Date(a.created_at));
                }
                else {
                    this.dData = this.dData.sort((a,b) => (b.numberOfUpvotes - b.numberOfDownvotes) - (a.numberOfUpvotes - a.numberOfDownvotes));
                }
                this.sortBy = sortBy;
                return this.dData;
            },
            /*
             * This function should:
             * - change the doodleSize boolean variable based on popularity or the set size 'standard'
             * - Return the doodle data so it can update accordingly
             */
            setDoodleSize: function(changeBy) {
                if(changeBy == "standard")
                {
                    this.doodleSize = true;
                }
                else if(changeBy == "popularity")
                {
                    this.doodleSize = false;
                }
                return this.dData;
            },
            /*
             * This function should:
             * - Use the doodleSize boolean variable to either:
             * -- Change the size of the images based on number of upvotes/downvotes
             * -- change the size of the images to the standard size
             * - return a style that changes the doodles size.
             */
            changeDoodleSize: function(doodle) {
                let result = {};
                let sizeMultiplier = 2/3;

                if(this.doodleSize == false) {
                    let dHeight = 0;

                    let downVotes = -(doodle.numberOfDownvotes);
                    let upVotes = doodle.numberOfUpvotes;
                    let overallVote = downVotes + upVotes;

                    dHeight = sizeMultiplier * (this.startHeight + overallVote);

                    if(dHeight > 80) {
                        dHeight = 80;
                    }
                    else if(dHeight < 30) {
                        dHeight = 30;
                    }

                    result = {'width': 'auto', 'height': dHeight + 'vh'};
                }
                else {
                    result = {'width': 'auto', 'height': sizeMultiplier * this.startHeight + 'vh'};
                }

                return result;
            },
            /*
             * This function should:
             * - Set the currentDoodle variable to the current doodle. May not be needed.
             */
            setCurrentDoodle: function(doodle) {
                this.currentDoodle = doodle;
            },
            /*
             * This function should:
             * - take the new user vote and either:
             * -- replace the old
             * -- create a new one
             * -- unset the old vote
             */
            onVote:function (doodle, userVote) {
                if(doodle.userVote == null) {
                    this.createVote(doodle.id, userVote);
                    doodle.userVote = userVote;
                }
                else if(doodle.userVote == userVote) {
                    this.saveVote(doodle.id, this.novote);
                    // set it to a number that isn't 1, -1, or 0 so it doesn't create another vote table.
                    doodle.userVote = 0;
                }
                else {
                    this.saveVote(doodle.id, userVote);
                    doodle.userVote = userVote;
                }
            },
            /*
             * This function should:
             * - create a new vote in the database using axios
             */
            createVote: function (doodleId, userVote) {
                axios.post('/votes', {
                    doodle_id: doodleId,
                    vote: userVote
                });
            },
            /*
             * This function should:
             * - save a new vote variable to the existing table in the database using axios
             */
            saveVote: function (id, userVote) {
                axios.patch('/votes/' + id.toString(), {
                    vote: userVote
                });
            },
            /*
             * This function should:
             * - create a new report table with the string that the user wrote for the 'report'
             *   and make the show variable false so that the image will have display: none
             * - return the current doodle in order to make it display: hidden
             */
            createReport: function () {
                this.currentDoodle.show = false;
                axios.post('/reports', {
                    doodle_id: this.currentDoodle.id,
                    report: this.reportString
                });
                this.reportString = '';
                return this.currentDoodle;
            },
            /*
             * This function should:
             * - call the database to get the individual image
             * - redirect to that individual image page.
             */
            doodleOnClick: function () {
                axios.get('/doodles/' + id.toString(), {
                    
                }).then(function (response) {
                    window.location = response.data.redirect;
                });
            }
        }
    }
</script>