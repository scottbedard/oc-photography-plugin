<?php namespace Bedard\Photography\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class ModifyCacheTable extends Migration
{
    public function up()
    {
        Schema::table('cache', function (Blueprint $table) {
            $table->longtext('value')->change();
        });
    }

    public function down()
    {
        //
    }
}
