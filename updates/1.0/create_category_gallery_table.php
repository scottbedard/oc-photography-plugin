<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCategoryGalleryTable extends Migration
{
    public function up()
    {
        Schema::create('bedard_photography_category_gallery', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('gallery_id')->unsigned();
            // $table->unique(['category_id', 'gallery_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_category_gallery');
    }
}
