<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenseImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('license_id')->unsigned();
            $table->foreign('license_id')->references('id')->on('licenses');
            $table->string('image_name');
            $table->string('public_path');
            $table->string('thumb_path');
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
        Schema::dropIfExists('license_images');
    }
}
