<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('bedard_photography_orders', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('email')->default('');
            $table->decimal('amount', 10, 2)->unsigned()->default(0);
            $table->string('status')->default('pending');
            $table->string('stripe_token')->default('');
            $table->integer('stripe_attempts')->unsigned()->default(0);
            $table->string('session_token', 40)->default('');
            $table->string('download_token', 40)->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bedard_photography_orders');
    }
}
