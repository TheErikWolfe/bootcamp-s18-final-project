<template>
    <div class="p-1">
    <div class="row justify-content-center">
        <div v-for="doodle in dData">
            <div class="img-frame" v-bind:style="changeDoodleSize(doodle)">
            <div class="img-props">
                <a :href="'/doodles/' + doodle.id">
                    <img :src=doodle.source v-bind:style="changeDoodleSize(doodle)">
                </a>
            </div>
            <div class="arrow-container">
                <div v-on:click="onVote(doodle, 1)" class="arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : doodle.userVote === 1 }"></i></div>
                <div v-on:click="onVote(doodle, -1)" class="arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : doodle.userVote === -1 }"></i></div>
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

                return {width: 'auto', height: this.dHeight + 'vh'};
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
            showSingleDoodle: function (id)
            {
                console.log("Showing Doodle of " + id);
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