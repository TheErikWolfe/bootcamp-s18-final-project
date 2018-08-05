<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->text('source')->default('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAABkCAYAAACoy2Z3AAAEFUlEQVR4Xu3V0WlDUQxEQbmzlJJUmJQY3MKaBXsZ/19hjR6cx/kRIECAAIFA4BG88YQAAQIECJyA+AgIECBAIBIQkIjNIwIECBAQEN8AAQIECEQCAhKxeUSAAAECAuIbIECAAIFIQEAiNo8IECBAQEB8AwQIECAQCQhIxOYRAQIECAiIb4AAAQIEIgEBidg8IkCAAAEB8Q0QIECAQCQgIBGbRwQIECAgIL4BAgQIEIgEBCRi84gAAQIEBMQ3QIAAAQKRgIBEbB4RIECAgID4BggQIEAgEhCQiM0jAgQIEBAQ3wABAgQIRAICErF5RIAAAQIC4hsgQIAAgUhAQCI2jwgQIEBAQHwDBAgQIBAJCEjE5hEBAgQICIhvgAABAgQiAQGJ2DwiQIAAAQHxDRAgQIBAJCAgEZtHBAgQICAgvgECBAgQiAQEJGLziAABAgQExDdAgAABApGAgERsHhEgQICAgPgGCBAgQCASEJCIzSMCBAgQEBDfAAECBAhEAgISsXlEgAABAgLiGyBAgACBSEBAIjaPCBAgQEBAfAMECBAgEAkISMTmEQECBAgIiG+AAAECBCIBAYnYPCJAgAABAfENEHhN4Ovufu/u5+7+XhvlNYHPEhCQz7qXf/t+As+APMPxLSDvdxz/qCsgIF1f0wkQIDArICCzp7UYAQIEugIC0vU1nQABArMCAjJ7WosRIECgKyAgXV/TCRAgMCsgILOntRgBAgS6AgLS9TWdAAECswICMntaixEgQKArICBdX9MJECAwKyAgs6e1GAECBLoCAtL1NZ0AAQKzAgIye1qLESBAoCsgIF1f0wkQIDArICCzp7UYAQIEugIC0vU1nQABArMCAjJ7WosRIECgKyAgXV/TCRAgMCsgILOntRgBAgS6AgLS9TWdAAECswICMntaixEgQKArICBdX9MJECAwKyAgs6e1GAECBLoCAtL1NZ0AAQKzAgIye1qLESBAoCsgIF1f0wkQIDArICCzp7UYAQIEugIC0vU1nQABArMCAjJ7WosRIECgKyAgXV/TCRAgMCsgILOntRgBAgS6AgLS9TWdAAECswICMntaixEgQKArICBdX9MJECAwKyAgs6e1GAECBLoCAtL1NZ0AAQKzAgIye1qLESBAoCsgIF1f0wkQIDArICCzp7UYAQIEugIC0vU1nQABArMCAjJ7WosRIECgKyAgXV/TCRAgMCsgILOntRgBAgS6AgLS9TWdAAECswICMntaixEgQKArICBdX9MJECAwKyAgs6e1GAECBLoCAtL1NZ0AAQKzAgIye1qLESBAoCsgIF1f0wkQIDArICCzp7UYAQIEugIC0vU1nQABArMCAjJ7WosRIECgKyAgXV/TCRAgMCsgILOntRgBAgS6Av9ZjQRliiW/GgAAAABJRU5ErkJggg==');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signatures');
    }
}
