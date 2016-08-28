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
            $table->string('name')->default('');
            $table->text('description');
            $table->text('description_html');
            $table->string('password')->default('');
            $table->decimal('photo_price', 10, 2)->unsigned()->default(0);
            $table->integer('watermark_id')->unsigned()->nullable();
            $table->string('watermark_text')->default('');
            $table->boolean('is_watermarked')->default(false);
            $table->boolean('is_featured')->default(false)->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_galleries');
    }

}
