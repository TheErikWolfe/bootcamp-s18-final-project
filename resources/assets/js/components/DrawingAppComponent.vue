<template>
    <!-- Temporary div for centering of the canvas. -->
    <div class="container">
    <div class="justify-content-center row">
        <div class="text-center drawing-app-width">
            <div class="row justify-content-center">
                <div v-for="color in colors">
                    <div v-on:click="changeColor(color)" class="swatch" v-bind:style="{ background : color }"></div>
                </div>
            </div>
            <canvas id="drawing-app-canvas"
                v-on:mousedown="handleMouseDown" 
                v-on:mouseup="handleMouseUp" 
                v-on:mousemove="handleMouseMove"
                width="400px"
                height="600px">
            </canvas>
            <div class="float-left">
                <button v-on:click="setRadius(-1)" class="btn btn-secondary">-</button>
                <button v-on:click="setRadius(1)" class="btn btn-secondary">+</button>
                <div>{{ radius / 5 }}</div>
            </div>
            <form v-on:submit.prevent="saveDoodle" class="float-right">
                <input type="hidden" name="_token" :value="csrf">
                <button class="btn btn-secondary"  type="submit">Save</button>
            </form>
        </div>
    </div>  
    </div>  
</template>

<script>
import axios from 'axios';
    export default 
    {
        data () 
        {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                context: null,
                canvas: null,
                mouseDown: false,
                radIncrement: 5,
                radius: 10,
                current: {
                    x: 0,
                    y: 0 
                },
                previous: {
                    x: 0,
                    y: 0
                },
                colors : ['black', 'grey', 'white', 'red', 'orange', 'yellow', 'green', 'indigo', 'violet'],
                currentColor : 'black'
            }
        },

        computed:
        {
            
        },

        mounted () 
        {
            this.canvas = document.getElementById('drawing-app-canvas');
            this.context = this.canvas.getContext('2d');

            this.context.rect(0, 0, this.canvas.width, this.canvas.height);
            this.context.fillStyle = "#FFF";
            this.context.fill();
        },
        methods: {
            changeColor: function (color)
            {
                this.currentColor = color; 
            },
            draw: function (event) 
            {
                if(this.mouseDown)
                {
                    this.context.lineWidth = this.radius * 2;
                    this.context.lineTo(this.current.x, this.current.y);
                    this.context.strokeStyle = this.currentColor;
                    this.context.stroke();
                    this.context.beginPath();
                    this.context.arc(this.current.x, this.current.y, this.radius, 0, 2*Math.PI*2);
                    this.context.fillStyle = this.currentColor;
                    this.context.fill();
                    this.context.beginPath();
                    this.context.moveTo(this.current.x, this.current.y);
                }
            },
            setRadius: function (radDir) 
            {
                this.radius = this.radius + radDir * this.radIncrement;
                if(this.radius <= 0)
                {
                    this.radius = 5;
                }
                if(this.radius >= 55)
                {
                    this.radius = 50;
                }
            },
            handleMouseMove: function (event) 
            {
                var rect = this.canvas.getBoundingClientRect();
                this.current = {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };

                this.draw(event);
            },
            handleMouseUp: function () 
            {
                this.mouseDown = false;
                
            },
            handleMouseDown: function (event)
            {
                var rect = this.canvas.getBoundingClientRect();
                this.context.beginPath();
                this.mouseDown = true;
                this.current = {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };
            },
            clearCanvas: function ()
            {

            },
            saveDoodle: function (event) {
                axios.post('/doodles', {
                    doodle: this.canvas.toDataURL()
                })
                .then(function (response) {
                    window.location = response.data.redirect;
                });
            },
        }
    }
</script>