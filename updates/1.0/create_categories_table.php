<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('bedard_photography_categories', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_categories');
    }
}
