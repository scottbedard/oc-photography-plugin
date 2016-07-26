<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRatesTable extends Migration
{
    public function up()
    {
        Schema::create('bedard_photography_rates', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->default('');
            $table->integer('photos')->unsigned()->default(0);
            $table->decimal('price_per_photo', 10, 2)->unsigned()->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_rates');
    }
}
