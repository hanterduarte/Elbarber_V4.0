<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('cashier_movements');
        Schema::dropIfExists('cashiers');
    }

    public function down()
    {
        Schema::create('cashiers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('opening_date');
            $table->dateTime('closing_date')->nullable();
            $table->decimal('opening_amount', 10, 2);
            $table->decimal('closing_amount', 10, 2)->nullable();
            $table->decimal('current_amount', 10, 2);
            $table->decimal('difference_amount', 10, 2)->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->text('opening_notes')->nullable();
            $table->text('closing_notes')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::create('cashier_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained('cashiers')->onDelete('cascade');
            $table->enum('type', ['opening', 'closing', 'sale', 'withdrawal', 'reinforcement']);
            $table->decimal('amount', 10, 2);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
}; 