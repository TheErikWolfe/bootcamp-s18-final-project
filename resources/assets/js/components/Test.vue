<template>
    <!-- Temporary div for centering of the canvas. -->
    <div style="text-align: center">
    <canvas id="drawing-app-canvas"
    width="400px"
    height="600px"> 
    </canvas>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                provider: {
                    context: null
                }
            }
        },

        provide() {
            return {
                provider: this.provider
            }
        },

        mounted() {
            this.provider.context = document.getElementById('drawing-app-canvas').getContext('2d');
        },

        render() {
            const ctx = this.provider.context;

            ctx.rect(100,100, 200, 200);
            ctx.fillStyle = this.color;
            ctx.fill();
        }
    }
</script>