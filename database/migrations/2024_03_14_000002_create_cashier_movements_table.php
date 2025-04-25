<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cashier_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['opening', 'closing', 'sale', 'withdrawal', 'reinforcement']);
            $table->decimal('amount', 10, 2);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashier_movements');
    }
}; 