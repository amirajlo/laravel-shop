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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('lead')->nullable();
            $table->text('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('content_title')->nullable()->comment('H1 in content');
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);


            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'articles_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('redirect')->nullable();
            $table->string('canonical')->nullable();
            $table->text('sidebar')->nullable();
            $table->string('related_articles')->nullable();
            $table->string('related_products')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('count_visit')->default(Main::SCORE_ONE);
            $table->integer('count_comment')->default(Main::STATUS_DEFAULT);
            $table->integer('count_score')->default(Main::SCORE_FIVE);
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->tinyInteger('is_commentable')->default(Main::STATUS_ACTIVE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
