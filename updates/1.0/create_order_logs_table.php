<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrderLogsTable extends Migration
{
    public function up()
    {
        Schema::create('bedard_photography_order_logs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id')->unsigned()->index();
            $table->string('status')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_order_logs');
    }
}
