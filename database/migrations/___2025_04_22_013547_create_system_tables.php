<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0);
            $table->text('bio')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('duration')->comment('Duration in minutes');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->string('barcode')->nullable()->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('User who opened the register');
            $table->foreignId('closed_by')->nullable()->constrained('users')->comment('User who closed the register');
            $table->decimal('initial_amount', 10, 2);
            $table->decimal('final_amount', 10, 2)->nullable();
            $table->decimal('cash_in', 10, 2)->default(0)->comment('Total cash received');
            $table->decimal('cash_out', 10, 2)->default(0)->comment('Total cash paid out');
            $table->decimal('card_total', 10, 2)->default(0)->comment('Total card transactions');
            $table->decimal('pix_total', 10, 2)->default(0)->comment('Total PIX transactions');
            $table->dateTime('opened_at');
            $table->dateTime('closed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('barber_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained()->comment('User who made the sale');
            $table->foreignId('cash_register_id')->constrained();
            $table->decimal('total', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'credit_card', 'debit_card', 'pix']);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->morphs('itemable');  // For products or services
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->foreignId('barber_id')->nullable()->constrained()->comment('For services only');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('cash_registers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('services');
        Schema::dropIfExists('barbers');
        Schema::dropIfExists('clients');
    }
}; 