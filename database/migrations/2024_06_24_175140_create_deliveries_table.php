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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('main_image')->nullable()->index();
            $table->float('fee')->default(Main::STATUS_DEFAULT);
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'deliveries_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
