<template>
    <!-- Temporary div for centering of the canvas. -->
    <div class="p-5 contain row justify-content-center">
        <div class="border-dark drawing-app-width row bg-secondary border p-0">
            <div class="col-2 pr-2 pt-1 p-0 border border-dark text-center">
                <div class="row mt-2 justify-content-center">
                    <div v-for="color in colors">
                        <div v-on:click="changeColor(color)" class="swatch" v-bind:class="{ 'active': currentColor === color }" v-bind:style="{ background : color }"></div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'pencil'"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'marker'"><i class="fas fa-marker"></i></button>
                    <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'spray'"><i class="fas fa-spray-can"></i></button>
                    <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'connecting'"><i class="fab fa-connectdevelop"></i></button>
                    <button class="btn border-dark btn-secondary" v-on:click="currentColor = 'white'"><i class="fas fa-eraser"></i></button>
                </div>
                <div class="text-light row justify-content-center text-center pl-2 mt-3">
                    <p><strong>Brush Size: </strong><br/>{{ (radius - 1) / radIncrement + 1 }}</p>
                    <button v-on:click="setRadius(-1)" class="btn border-dark btn-secondary">-</button>
                    <button v-on:click="setRadius(1)" class="btn border-dark btn-secondary">+</button>
                </div>
                <div class="save-button">
                    <form v-on:submit.prevent="saveDoodle" class="row justify-content-center align-items-end">
                        <input type="hidden" name="_token" :value="csrf">
                        <button class="btn border-dark btn-secondary"  type="submit">Save</button>
                    </form>
                </div>
            </div>
            <div class="col-10 p-1">
                <canvas id="drawing-app-canvas"
                    v-on:mousedown="handleMouseDown" 
                    v-on:mouseup="handleMouseUp" 
                    v-on:mousemove="handleMouseMove"
                    v-on:mouseleave="handleMouseUp"
                    width="400px"
                    height="600px"
                    class="m-0">
                </canvas>
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
                radIncrement: 3,
                radius: 10,
                maxRadius: 28,
                minRadius: 1,
                current: {
                    x: 0,
                    y: 0 
                },
                colors : ['black', 'grey', 'white', 'brown', 'red', 'orange', 'yellow', 'green', 'indigo', 'violet', 'blue', 'lightblue'],
                currentColor : 'black',
                strokeStyle: 'pencil',
                timeout: null,
                density: 50,
                points: []
            }
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
            drawConnecting: function(event)
            {
                if (!this.mouseDown) 
                {
                    return;
                }
                this.points.push({ x: this.current.x, y: this.current.y });

                this.context.beginPath();
                console.log(this.points[this.points.length - 2]);
                this.context.moveTo(this.points[this.points.length - 2].x, this.points[this.points.length - 2].y);
                this.context.lineTo(this.points[this.points.length - 1].x, this.points[this.points.length - 1].y);
                this.context.stroke();
                let dx = 0;
                let dy = 0;
                let d = 0;
                for (var i = 0, len = this.points.length; i < len; i++) 
                {
                    dx = this.points[i].x - this.points[this.points.length-1].x;
                    dy = this.points[i].y - this.points[this.points.length-1].y;
                    d = dx * dx + dy * dy;
                    if (d < 1000) 
                    {
                        this.context.beginPath();
                        this.context.strokeStyle = 'rgba(0,0,0,0.3)';
                        this.context.moveTo( this.points[this.points.length-1].x + (dx * 0.2), this.points[this.points.length-1].y + (dy * 0.2));
                        this.context.lineTo( this.points[i].x - (dx * 0.2), this.points[i].y - (dy * 0.2));
                        this.context.stroke();
                    }
                }
            },
            draw: function (event) 
            {
                if(this.mouseDown)
                {
                    this.context.lineWidth = this.radius * 2;
                    if(this.strokeStyle == "marker")
                    {
                        this.context.shadowBlur = this.radius;
                        this.context.shadowColor = this.currentColor;
                    }
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
                if(this.radius < this.minRadius)
                {
                    this.radius = this.minRadius;
                }
                else if(this.radius > this.maxRadius)
                {
                    this.radius = this.maxRadius;
                }
            },
            handleMouseMove: function (event) 
            {
                var rect = this.canvas.getBoundingClientRect();
                this.current = {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                }
                if(this.strokeStyle == 'connecting')
                {
                    this.drawConnecting(event);
                }
                else if(this.strokeStyle != 'spray')
                {
                    this.draw(event);
                }
            }, 
            handleMouseUp: function () 
            {
                this.mouseDown = false;
                clearTimeout(this.timeout);
                this.context.shadowBlur = 0;
                
            },
            getRandomFloat: function (min, max) {
                return Math.random() * (max - min) + min;
            },
            handleMouseDown: function (event)
            {
                // console.log("made it into mouseDown");
                
                var rect = this.canvas.getBoundingClientRect();
                
                this.mouseDown = true;
                this.current = {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };
                
                if(this.strokeStyle == 'spray')
                {
                    this.context.lineJoin = this.context.lineCap = 'round';
                    self = this;
                    this.timeout = setTimeout(function spray() {
                        for (var i = self.density; i-- ; ) {
                            var angle = self.getRandomFloat(0, Math.PI*2);
                            var radius = self.getRandomFloat(0, 20);
                            self.context.fillStyle = self.currentColor;
                            var addedx = self.current.x + radius * Math.cos(angle)
                            var addedy = self.current.y + radius * Math.sin(angle);
                            self.context.fillRect(
                                self.current.x + radius * Math.cos(angle),
                                self.current.y + radius * Math.sin(angle), 
                                1, 1);
                        }
                        if (!self.timeout) return;
                        self.timeout = setTimeout(spray, 50);
                    }, 50);
                }
                else if(this.strokeStyle == 'connecting')
                {
                    console.log('made it to draw connecting in mouseDown');
                    this.context.lineWidth = this.radius;
                    this.context.lineJoin = this.context.lineCap = 'round';
                    this.points = [ ];
                    this.points.push({ x: this.current.x, y: this.current.y });
                }
                else 
                {
                    this.context.beginPath();
                    this.context.arc(this.current.x, this.current.y, this.radius, 0, 2*Math.PI*2);
                    this.context.fillStyle = this.currentColor;
                    this.context.fill();
                    this.context.beginPath();
                    this.context.lineJoin = this.context.lineCap = 'round';
                }
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