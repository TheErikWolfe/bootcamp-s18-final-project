<template>
    <div class="container">
        <div class="bg-secondary rounded pt-1 pb-2">
            <h3 v-if="doodlesData.length > 0" class="text-center mt-3"><strong>You have {{ doodlesData.length }} images, keep up the great doodling!</strong></h3>
            <h3 v-else class="text-center mt-3"><strong>You have no doodles :(</strong></h3>
        </div>
        <div class="row justify-content-center">
            <div v-for="doodle in dData" class="text-center user-img-wrapper m-4">
                <div class="user-img-thumbnail rounded border border-secondary">
                    <a :href="'/doodles/' + doodle.id">
                        <img class="user-img" :src=doodle.source>
                    </a>
                </div>
                <form method="post" :action="'/doodles/' + doodle.id">
                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm bg-transparent border-0"><i class="text-danger fas fa-trash-alt"></i></button>
                </form>
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
            }
        },
        mounted() {
            this.dData = this.doodlesData;
        },
        methods: {
            /*
             * This function should:
             * - call the database to get the individual image
             * - redirect to that individual image page.
             */
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