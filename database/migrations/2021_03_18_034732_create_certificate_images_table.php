<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('certificate_id')->unsigned();
            $table->foreign('certificate_id')->references('id')->on('certificates');
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
        Schema::dropIfExists('certificate_images');
    }
}
