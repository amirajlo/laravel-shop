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
        Schema::create('order_notes', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->foreignId('order_id')->nullable()
                ->constrained(table: 'orders', indexName: 'order_notes_order_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'order_notes_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('status')->default(Main::STATUS_DEFAULT);
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
        Schema::dropIfExists('order_notes');
    }
};
