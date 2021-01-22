<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image');
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
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign('brands_image_id_foreign');
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->dropForeign('product_types_image_id_foreign');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_image_id_foreign');
        });

        Schema::dropIfExists('images');
    }
}
