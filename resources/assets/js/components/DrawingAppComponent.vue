<template>
    <!-- Temporary div for centering of the canvas. -->
    <div style="text-align: center">
    <canvas id="drawing-app-canvas"
        v-on:mousedown="handleMouseDown" 
        v-on:mouseup="handleMouseUp" 
        v-on:mousemove="handleMouseMove"
        width="400px"
        height="600px"> 
    </canvas>
    </div>
</template>

<script>
    export default 
    {
        data () 
        {
            return {
                context: null,
                canvas: null,
                mouseDown: false,
                radius: 10,
                current: {
                    x: 0,
                    y: 0 
                },
                previous: {
                    x: 0,
                    y: 0
                }
            }
        },

        computed:
        {
            // currentMouse: function (event) {
            //     var c = this.canvas;
            //     var rect = c.getBoundingClientRect();

            //     return {
            //         x: (event.clientX - rect.left),
            //         y: (event.clientY - rect.top)
            //     }
            // }
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
            draw: function (event) 
            {
                if(this.mouseDown)
                {
                    this.context.lineWidth = this.radius * 2;
                    this.context.lineTo(this.current.x, this.current.y);
                    this.context.stroke();
                    this.context.beginPath();
                    this.context.arc(this.current.x, this.current.y, this.radius, 0, 2*Math.PI*2);
                    this.context.fillStyle = "black";
                    this.context.fill();
                    this.context.beginPath();
                    this.context.moveTo(this.current.x, this.current.y);
                }
            },
            setRadius: function () 
            {

            },
            handleMouseMove: function (event) 
            {
                var rect = this.canvas.getBoundingClientRect();
                this.current = {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };

                // var mousePos = {x: event.clientX - rect.left,
                // y: event.clientY - rect.top };
                // var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
                // this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
                // this.context.font = '18pt Calibri';
                // this.context.fillStyle = 'black';
                // this.context.fillText(message, 10, 25);

                this.draw(event);
            },
            handleMouseUp: function () 
            {
                this.mouseDown = false;
                
            },
            handleMouseDown: function (event)
            {
                this.context.beginPath();
                this.mouseDown = true;
                this.current = {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };

                //this.context.moveTo(this.currentMouse.x, this.currentMouse.y)
            },
            clearCanvas: function ()
            {

            }
        }
    }
</script>