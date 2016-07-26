<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGalleryRateTable extends Migration
{
    public function up()
    {
        Schema::create('bedard_photography_gallery_rate', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('gallery_id')->unsigned();
            $table->integer('rate_id')->unsigned();
            $table->unique(['gallery_id', 'rate_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_gallery_rate');
    }
}
