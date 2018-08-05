<template>
    <div class="text-center">
        <div class="row mx-auto signature-canvas bg-light">
            <canvas id="drawing-app-canvas"
                    v-on:mousedown="handleMouseDown" 
                    v-on:mouseup="handleMouseUp" 
                    v-on:mousemove="handleMouseMove"
                    v-on:mouseleave="handleMouseUp"
                    width="400px"
                    height="100px"
                    class="m-0">
            </canvas>
        </div>
        <div class="mt-2">
            <p>Your signature will show up at the bottom of every doodle you make, so make it good</p>
        </div>
        <div class="mt-3">
            <input type="hidden" name="_token" :value="csrf">
            <div v-on:click="clearCanvas()" class="ml-5 float-left btn btn-dark">Clear</div>
            <div v-on:click="saveSignature()" class="mr-5 float-right btn btn-dark">Save</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['signatureData'],
        data () 
        {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                context: null,
                canvas: null,
                mouseDown: false,
                radius: 1,
                current: {
                    x: 0,
                    y: 0 
                },
                currentColor : 'black'
            }
        },
        mounted() {
            this.canvas = document.getElementById('drawing-app-canvas');
            this.context = this.canvas.getContext('2d');

            this.context.rect(0, 0, this.canvas.width, this.canvas.height);
            console.log(this.signatureData.id)
        },
        methods: {
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
                this.context.arc(this.current.x, this.current.y, this.radius, 0, 2*Math.PI*2);
                this.context.fillStyle = this.currentColor;
                this.context.fill();
                this.context.beginPath();
            },
            clearCanvas: function()
            {
                this.canvas.width = 400;
                this.canvas.height = 100;
            },
            saveSignature: function (event) {
                if(this.signatureData == undefined)
                {
                    axios.post('/signature', {
                        signature: this.canvas.toDataURL()
                    })
                    .then(function (response) {
                        window.location = response.data.redirect;
                    });
                }
                else
                {
                    axios.put('/signature/' + this.signatureData.id, {
                        signature: this.canvas.toDataURL()
                    })
                    .then(function (response) {
                        window.location = response.data.redirect;
                    });
                }
            },
        }
    }
</script>