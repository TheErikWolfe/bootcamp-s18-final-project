<template>
    <div>
        <div v-for="doodle in dData" class="img-frame">
            <div class="img-props">
                <a :href="'/doodles/' + doodle.id">
                    <img :src=doodle.source>
                </a>
            </div>
            <div class="arrow-container">
                <div v-on:click="onVote(doodle, 1)" class="arrow bg-transparent"><i class="fa fa-arrow-up upvote-arrow" v-bind:class="{ 'upvote-arrow-active' : doodle.userVote === 1 }"></i></div>
                <div v-on:click="onVote(doodle, -1)" class="arrow bg-transparent"><i class="fa fa-arrow-down downvote-arrow" v-bind:class="{ 'downvote-arrow-active' : doodle.userVote === -1 }"></i></div>
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
                novote: 0
            }
        },

        mounted() {
            console.log(this.doodlesData);
            this.dData = this.doodlesData;
        },

        computed: {
            
        },

        methods: {
            onVote:function (doodle, userVote) 
            {
                console.log(doodle.userVote, userVote);
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