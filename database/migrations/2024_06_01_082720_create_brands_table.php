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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('en_title')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('main_image')->nullable()->index();
            $table->foreignId('header_image')->nullable()->index();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('content_title')->nullable()->comment('H1 in content');
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);

            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'brands_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('redirect')->nullable();
            $table->string('canonical')->nullable();
            $table->text('sidebar')->nullable();
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
        Schema::dropIfExists('brands');
    }
};
