<?php

use App\Models\Main;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(Main::CATEGORY_TYPE_PRODUCT)->comment("محصول یا مقاله و...");
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

            $table->foreignId('parent_id')->nullable()
                ->constrained(table: 'categories', indexName: 'categories_parent_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'categories_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('redirect')->nullable();
            $table->string('canonical')->nullable();
            $table->text('sidebar')->nullable();
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();
        });


        $cats = [
            [
                'title' => 'کالای دیجیتال',
                'slug' => 'کالای-دیجیتال',
                'parent_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'آشپزخانه',
                'slug' => 'آشپزخانه',
                'parent_id' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'موبایل',
                'slug' => 'موبایل',
                'parent_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'لپتاپ',
                'slug' => 'لپتاپ',
                'parent_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];
        DB::table('categories')->insert($cats);

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('en_title')->nullable();
            $table->text('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('content_title')->nullable()->comment('H1 in content');
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->foreignId('parent_id')->nullable()
                ->constrained(table: 'tags', indexName: 'tags_parent_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'tags_author_id')
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
        Schema::dropIfExists('categories');
    }
};
