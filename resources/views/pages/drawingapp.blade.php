@extends('layouts.app')

@section('content')

<!-- <drawing-board></drawing-board> -->
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
    </div>

@endsection