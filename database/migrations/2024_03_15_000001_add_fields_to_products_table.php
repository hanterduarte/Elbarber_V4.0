<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('description');
            $table->integer('initial_stock')->default(0)->after('stock');
            $table->integer('min_stock')->default(0)->after('initial_stock');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['photo', 'initial_stock', 'min_stock']);
        });
    }
}; 