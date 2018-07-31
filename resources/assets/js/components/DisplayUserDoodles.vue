<template>
    <div class="container">
        <h3 class="text-center mt-3"><strong>You have {{ doodlesData.length }} images, keep up the great doodling!</strong></h3>
        <div class="row justify-content-center">
            <div v-for="doodle in dData" class="user-img-wrapper m-4">
                <div class="user-img-thumbnail rounded border border-secondary">
                    <a :href="'/doodles/' + doodle.id">
                        <img class="user-img" :src=doodle.source>
                    </a>
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