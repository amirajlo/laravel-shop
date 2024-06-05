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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('positive_points')->nullable();
            $table->string('negative_points')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('mobile')->nullable();
            $table->string('model_type')->nullable();
            $table->string('ip')->nullable();
            $table->foreignId('parent_id')->nullable()
                ->constrained(table: 'comments', indexName: 'comments_parent_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('score')->default(Main::SCORE_FIVE);
            $table->tinyInteger('status')->default(Main::STATUS_DISABLED);
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->integer('like')->default(Main::STATUS_DEFAULT);
            $table->integer('diss_like')->default(Main::STATUS_DEFAULT);
            $table->softDeletes();
            $table->timestamps();
            $table->index(array('model_id', 'model_type'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
};
