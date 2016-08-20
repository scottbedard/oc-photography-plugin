<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateOrderPhotoTable extends Migration
{
    public function up()
    {
        Schema::create('bedard_photography_order_photo', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('photo_id')->unsigned();
            $table->unique(['order_id', 'photo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_order_photo');
    }
}
