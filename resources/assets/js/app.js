
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('drawing-board', {
    template: `
    <div class="container">
    <div class="card settings-card p-0">
    <div class="card-body mt-0">
    <canvas id="canvas" 
        style="padding-left: 0;
        padding-right: 0;
        margin-top: 0px;
        margin-left: auto;
        margin-right: auto;
        display: block;" 
        v-on:mousedown="handleMouseDown" 
        v-on:mouseup="handleMouseUp" 
        v-on:mousemove="handleMouseMove" 
        width="400%" 
        height="600%">
    </canvas>
    </div>
    </div>
    </div>`,
    data: function () {
        return {
            mouse: {
                current: {
                    x: 0,
                    y: 0
                },
                previous: {
                    x: 0,
                    y: 0
                },
                down: false
            }
        }
    },
    computed: {
        currentMouse: function () {
            var c = document.getElementById("canvas");
            var rect = c.getBoundingClientRect();
            
            return {
                x: this.mouse.current.x - rect.left,
                y: this.mouse.current.y - rect.top
            }
        }
    },
    created() {
        this.$parent.$on('stateChange', function($event) {
            var c = document.getElementById("canvas");
            var ctx = c.getContext("2d");

            ctx.rect(0, 0, ctx.width, ctx.height);
            ctx.fillStyle = "red";
            ctx.fill();
        });
    },
    methods: {
        draw: function (event) {       
            // requestAnimationFrame(this.draw);
            if (this.mouse.down ) {
                var c = document.getElementById("canvas");

                var ctx = c.getContext("2d");
                
                ctx.clearRect(0,0,ctx.width,ctx.height);
                

                ctx.lineTo(this.currentMouse.x, this.currentMouse.y);
                ctx.strokeStyle ="#F63E02";
                ctx.lineWidth = 2;
                ctx.stroke()
            }
        
        },
        handleMouseDown: function (event) {
            this.mouse.down = true;
            this.mouse.current = {
                x: event.pageX,
                y: event.pageY
            }

            var c = document.getElementById("canvas");
            var ctx = c.getContext("2d");

            ctx.moveTo(this.currentMouse.x, this.currentMouse.y)
        },
        handleMouseUp: function () {
            this.mouse.down = false;
        },
        handleMouseMove: function (event) {

            this.mouse.current = {
                x: event.pageX,
                y: event.pageY
            }
            
            this.draw(event)
            
            }
        },
        ready: function () {
                        
        var c = document.getElementById("canvas");
        var ctx = c.getContext("2d");
        ctx.translate(0.5, 0.5);
        ctx.imageSmoothingEnabled= false;
    }
});

const app = new Vue({
    el: '#app'
});
