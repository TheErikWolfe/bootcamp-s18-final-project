
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
Vue.component('test', require('./components/Test.vue'));

Vue.component('drawing-board', {
    template: `
    <div class="drawing-app-wrapper">
        <div class="drawing-app-button-navbar">
            <div class="button-wrapper">
                <div class="canvas-button"><img class="button-image" height="35px" width="35px" src="https://png.icons8.com/ios/40/000000/paint-brush.png"></div>
                <div class="canvas-button"><img class="button-image" height="35px" width="35px" src="https://png.icons8.com/ios/40/000000/fill-color.png"></div>
                <div class="canvas-button"><img class="button-image" height="35px" width="35px" src="https://png.icons8.com/ios/40/000000/erase-filled.png"></div>
                <div class="canvas-button"><img class="button-image" height="35px" width="35px" src="https://png.icons8.com/ios/40/000000/pencil.png"></div>
            </div>
        </div>
        <div style="display:inline-block;">
            <canvas id="drawing-app-canvas"
                v-on:mousedown="handleMouseDown" 
                v-on:mouseup="handleMouseUp" 
                v-on:mousemove="handleMouseMove" 
                width="400px"
                height="600px"> 
            </canvas>
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
            var c = document.getElementById("drawing-app-canvas");
            var rect = c.getBoundingClientRect();
            
            return {
                x: this.mouse.current.x - rect.left,
                y: this.mouse.current.y - rect.top
            }
        }
    },
    created() {
        this.$parent.$on('stateChange', function($event) {
            var c = document.getElementById("drawing-app-canvas");
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
                var c = document.getElementById("drawing-app-canvas");

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

            var c = document.getElementById("drawing-app-canvas");
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
                        
        var c = document.getElementById("drawing-app-canvas");
        var ctx = c.getContext("2d");
        ctx.translate(0.5, 0.5);
        ctx.imageSmoothingEnabled= false;
    }
});

const app = new Vue({
    el: '#app'
});
