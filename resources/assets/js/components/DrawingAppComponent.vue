<template>
    <!-- Temporary div for centering of the canvas. -->
    <div class="p-3 row justify-content-center">
        <div class="col-lg-2 pr-2 mt-2 pt-1 border rounded shadow-lg bg-secondary border-dark text-center">
            <div class="row mt-2 bg-dark border rounded border-dark justify-content-center p-1 m-3">
                <div v-for="color in colors">
                    <div v-on:click="changeColor(color)" class="swatch" v-bind:class="{ 'active': currentColor === color }" v-bind:style="{ background : color }"></div>
                </div>
            </div>
            <div class="row bg-dark border rounded border-dark justify-content-center m-3 p-1">
                <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'pencil'"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'marker'"><i class="fas fa-marker"></i></button>
                <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'spray'"><i class="fas fa-spray-can"></i></button>
                <button class="btn border-dark btn-secondary" v-on:click="strokeStyle = 'connecting'"><i class="fab fa-connectdevelop"></i></button>
                <button class="btn border-dark btn-secondary" v-on:click="currentColor = 'white', strokeStyle='pencil'"><i class="fas fa-eraser"></i></button>
            </div>
            <div class="text-light bg-dark border rounded border-dark row justify-content-center text-center pl-2 m-3">
                <p><strong>Brush Size: </strong><br/>{{ (radius - 1) / radIncrement + 1 }}</p>
                <button v-on:click="setRadius(-1)" class="ml-3 my-2 btn border-dark btn-secondary"><i class="fas fa-minus"></i></button>
                <button v-on:click="setRadius(1)" class="my-2 btn border-dark btn-secondary"><i class="fas fa-plus"></i></button>
            </div>
            <div class="row my-3 justify-content-center">
                <form v-on:submit.prevent="saveDoodle">
                    <input type="hidden" name="_token" :value="csrf">
                    <button class="btn border-dark btn-secondary"  type="submit">Save</button>
                </form>
            </div>
        </div>
        <div class="border-dark mt-2 rounded shadow-lg col-lg-5 bg-secondary border p-0">
            <div class="p-1 row justify-content-center">
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
                colors : ['black', 'grey', 'darkgrey', 'lightgrey', 'white', '#8B4513', '#A0522D', '#A52A2A', '#ff0000', '#ff4000', '#ff8000', '#ffbf00', '#ffff00', '#bfff00', '#80ff00', '#40ff00', '#009900', '#00ff00', '#00ff40', '#00ff80', '#00ffbf', '#00ffff', '#00bfff', '#0080ff', '#0040ff', '#0000ff', '#4000ff', '#8000ff', '#bf00ff', '#ff00ff', '#ffccff', '#ff00bf', '#ff0080', '#ff0040'],
                currentColor : 'black',
                strokeStyle: 'pencil',
                timeout: null,
                density: 50,
                points: []
            }
        },
        /*
         * On mounting this should:
         * - get the context of the canvas
         * - set the background to white so it doesn't make it a transparent background
         */
        mounted () 
        {
            this.canvas = document.getElementById('drawing-app-canvas');
            this.context = this.canvas.getContext('2d');

            this.context.rect(0, 0, this.canvas.width, this.canvas.height);
            this.context.fillStyle = "#FFF";
            this.context.fill();
        },
        methods: {
            /*
             * This function should:
             * - Take the current bounding client
             * - set the current x and y coords 
             */
            setCurrentCoords: function(event) {
                // Have to use getBoundingClient on the canvas otherwise the coordinates are off by about half.
                var rect = this.canvas.getBoundingClientRect();
                this.current = {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };
            },
            /*
             * This function should:
             * - set the current color to whatever color was chosen from the swatches
             */
            changeColor: function (color)
            {
                this.currentColor = color; 
            },
            /*
             * This function should:
             * - push the new set of x and y coordinates into the points array
             * - make a new line between the two circles
             * - compare the distance between the points in the array to the current one
             * - draw a line between them 
             */
            drawConnecting: function(event)
            {
                if (!this.mouseDown) 
                {
                    return;
                }
                this.points.push({ x: this.current.x, y: this.current.y });

                this.context.beginPath();
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
                        this.context.strokeStyle = this.currentColor;
                        this.context.moveTo( this.points[this.points.length-1].x + (dx * 0.2), this.points[this.points.length-1].y + (dy * 0.2));
                        this.context.lineTo( this.points[i].x - (dx * 0.2), this.points[i].y - (dy * 0.2));
                        this.context.stroke();
                    }
                }
            },
            /*
             * This function should:
             * - Make a circle on the previous mouse position
             * - Start a line
             * - Make a circle on the current mouse position
             * - End the line
             * So when you are looking at it, it draws a circle and another circle, then connects the two with a line.
             */
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
            /*
             * This function should:
             * - take the current radius and add on the radius increment
             * - set the radius to the max if it is over it
             * - set the radius to the min if it is under it
             */
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
            /*
             * This function should:
             * - get the call corresponding functions based on if it is the 'pencil'/'marker' 'stroke style' or if it is the 'connecting'
             */
            handleMouseMove: function (event) 
            {
                this.setCurrentCoords(event);
                if(this.strokeStyle == 'connecting')
                {
                    this.drawConnecting(event);
                }
                else if(this.strokeStyle != 'spray')
                {
                    this.draw(event);
                }
            }, 
            /*
             * This function should:
             * - set the mouseDown boolean variable to false so the canvas doesn't keep drawing
             * - clear the timeout interval (for spray)
             * - set the shadowBlur back to 0 (for the marker)
             */
            handleMouseUp: function () 
            {
                this.mouseDown = false;
                clearTimeout(this.timeout);
                this.context.shadowBlur = 0;
            },
            /*
             * This function should:
             * - get a random float with the maximum and miniimum variables that were passed in
             * just a helper function
             */
            getRandomFloat: function (min, max) {
                return Math.random() * (max - min) + min;
            },
            /*
             * This function should:
             * - set the mouseDown Boolean variable to true so th canvas knows when to draw
             * - check to see if the 'stroke style' is set
             * -- if it is, it sets a timeout function where it will get random points in a circle and fill it with randomly placed small squares
             * - Else if it should check to see if it is the 'connecting' 'stroke style' and if it is it should push the start coordinates into the points array
             * - Otherwise it should:
             * -- Start the initial path
             * -- Draw the initial circle (It won't draw a circle on click if I don't do it here)
             * -- Begin the line path  
             */
            handleMouseDown: function (event)
            {
                this.mouseDown = true;
                this.setCurrentCoords(event);
                
                if(this.strokeStyle == 'spray')
                {
                    this.context.lineJoin = this.context.lineCap = 'round';
                    self = this;
                    this.timeout = setTimeout(function spray() {
                        var sprayRadMultiplier = 3;
                        for (var i = self.density; i-- ; ) {
                            var angle = self.getRandomFloat(0, Math.PI*2);
                            var radius = self.getRandomFloat(0, self.radius * sprayRadMultiplier);
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
                    this.context.lineWidth = this.radius;
                    this.context.lineJoin = this.context.lineCap = 'round';
                    // resets the points so it only connects lines between the new set of points
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
            /*
             * This function should:
             * - make the canvas into base64
             * - save it to the database with axios
             */
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