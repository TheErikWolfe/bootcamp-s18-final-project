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
        data () {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                context: null,
                canvas: null,
                mouseDown: false,
                radius: 2,
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
             * - Make a circle on the previous mouse position
             * - Start a line
             * - Make a circle on the current mouse position
             * - End the line
             * So when you are looking at it, it draws a circle and another circle, then connects the two with a line.
             */
            draw: function (event) {
                if(this.mouseDown) {
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
            /*
             * This funcion should:
             * - Set the current mouse position
             * - call the draw function
             */
            handleMouseMove: function (event) {
                this.setCurrentCoords(event);
                this.draw(event);
            },
            /*
             * This function should:
             * - Just change mouseDown state to false so the canvas knows to stop drawing
             */
            handleMouseUp: function () {
                this.mouseDown = false;
                
            },
            /*
             * This function should:
             * - Set mouseDown state to true
             * - Start the initial path
             * - Draw the initial circle (It won't draw a circle on click if I don't do it here)
             * - Begin the line path   
             */
            handleMouseDown: function (event) {
                this.mouseDown = true;
                this.context.beginPath();
                this.setCurrentCoords(event);
                this.context.arc(this.current.x, this.current.y, this.radius, 0, 2*Math.PI*2);
                this.context.fillStyle = this.currentColor;
                this.context.fill();
                this.context.beginPath();
            },
            /*
             * This function should:
             * - set the initial height and width of the canvas to 400 x 100
             */
            clearCanvas: function() {
                // set to 400 because that is a standard screen size for cellphones
                this.canvas.width = 400;
                // set to 100 because a 4 to 1 ratio works extremely well for placing signature in 
                // bottom right hand of doodle on home page and single doodle page
                this.canvas.height = 100;
            },
            /*
             * This function should:
             * - Convert canvas to base64
             * - Save the 'signature' in the database with axios
             * - Redirect to home
             */
            saveSignature: function (event) {
                if(this.signatureData == undefined) {
                    axios.post('/signature', {
                        signature: this.canvas.toDataURL()
                    })
                    .then(function (response) {
                        window.location = response.data.redirect;
                    });
                }
                else {
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