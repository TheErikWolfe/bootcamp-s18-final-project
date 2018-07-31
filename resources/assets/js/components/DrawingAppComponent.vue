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
        <form v-on:submit.prevent="saveDoodle">
            <input type="hidden" name="_token" :value="csrf">
            <button class="btn btn-secondary"  type="submit">Save</button>
        </form>
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

                //this.context.moveTo(this.currentMouse.x, this.currentMouse.y)
            },
            clearCanvas: function ()
            {

            },
            saveDoodle: function (event) {
                // const fd = new FormData(event.target);
                // fd.append('doodle', this.canvas.toDataURL());
                axios.post('/doodles', {
                    doodle: this.canvas.toDataURL()
                })
                .then(function (response) {
                    window.location = response.data.redirect;
                });
                    
                // var formData = new FormData(event.target);
                // console.log("made it to saveDoodle");
                // formData.append('base64Doodle', this.canvas.toDataURL());
                // this.$http.post('/doodles', formData);
            },
        }
    }
</script>