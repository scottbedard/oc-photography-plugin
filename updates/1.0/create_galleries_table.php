<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGalleriesTable extends Migration
{

    public function up()
    {
        Schema::create('bedard_photography_galleries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('title')->default('');
            $table->text('description')->default('');
            $table->decimal('photo_price', 10, 2)->unsigned()->default(0);
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_galleries');
    }

}