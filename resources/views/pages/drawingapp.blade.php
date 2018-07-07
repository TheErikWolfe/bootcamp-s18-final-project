@extends('layouts.app')

@section('content')

<!-- <drawing-board></drawing-board> -->
<div style="
    background: #263960;
    position: relative;
    width: 554px;
    height: 601px;
    margin-right: 0%;
    top: 10%;
    right: 0;
    left: 0;
    margin-right: auto;
    margin-left: auto;">
        <div style="display:inline-block;
        width: 150px;
        height:600px;
        vertical-align: top;
        ">
        <div class="wrapper">
            <div class="canvas-button"><img src="https://png.icons8.com/ios/40/000000/paint-brush.png"></div>
            <div class="canvas-button"><img src="https://png.icons8.com/ios/40/000000/fill-color.png"></div>
            <div class="canvas-button"><img src="https://png.icons8.com/ios/40/000000/erase-filled.png"></div>
            <div class="canvas-button"><img src="https://png.icons8.com/ios/40/000000/pencil.png"></div>
        </div>
        </div>
        <div style="display:inline-block;">
            <canvas id="canvas"
                v-on:mousedown="handleMouseDown" 
                v-on:mouseup="handleMouseUp" 
                v-on:mousemove="handleMouseMove" 
                width="400px"
                height="600px"> 
            </canvas>
        </div>
    </div>

@endsection