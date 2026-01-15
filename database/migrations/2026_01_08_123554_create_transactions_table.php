<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained()->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete();

            $table->string('customer_name');
            $table->integer('quantity');

            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 10, 2);

            $table->enum('status', [
                'draft',
                'ordered',
                'accepted',
                'completed',
                'cancelled'
            ])->default('draft');

            $table->enum('payment_method', ['cash', 'cashless'])->nullable();

            $table->text('notes')->nullable();
            $table->text('receipt')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
