<template>
    <div>
        <div v-for="doodle in doodlesData" class="img-frame">
            <div class="img-props">
                <img :src=doodle.source alt="">
            </div>
            <div class="arrow-container">
                <div class="d-inline-flex arrow bg-transparent fa fa-arrow-up upvote-arrow"></div>
                <div class="d-inline-flex arrow bg-transparent fa fa-arrow-down downvote-arrow"></div>
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
            }
        },

        mounted() {
            
        },

        computed: {

        }
    }
</script>