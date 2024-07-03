<?php

use App\Models\Main;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('trace_number')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->foreignId('order_id')->nullable()
                ->constrained(table: 'orders', indexName: 'payments_order_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
