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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('en_title')->nullable();
            $table->text('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->foreignId('main_image')->nullable()->index();
            $table->foreignId('header_image')->nullable()->index();

            $table->string('seo_description')->nullable();
            $table->string('content_title')->nullable()->comment('H1 in content');
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->string('categories')->nullable();
            $table->string('tags')->nullable();
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'products_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()
                ->constrained(table: 'brands', indexName: 'products_brand_id')
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

            $table->tinyInteger('show_price')->nullable()->default(Main::STATUS_ACTIVE)->comment('نمایش قیمت اگر یک بود-دو بود متن جایگزین');

            $table->tinyInteger('price_type')->default(Main::STATUS_ACTIVE)->comment('یک بود عادی - دو بود دلاری');
            $table->double('price')->nullable()->default(Main::STATUS_DEFAULT)->comment('قیمت عادی');
            $table->double('price_special')->nullable()->default(Main::STATUS_DEFAULT)->comment('قیمت فروش ویژه');

            $table->double('price_currency')->nullable()->default(Main::STATUS_DEFAULT)->comment('قیمت دلار یا یورو عادی');
            $table->double('price_currency_special')->nullable()->default(Main::STATUS_DEFAULT)->comment('قیمت دلار یا یورو فروش ویژه');

            $table->dateTime('price_special_from')->nullable();
            $table->dateTime('price_special_to')->nullable();

            $table->tinyInteger('manage_stock')->default(Main::STATUS_DISABLED)->comment('اگر غیر فعال باشد فقط وضعیت رو مشخص میکنه - موجود یا ناموجود');
            $table->tinyInteger('stock_status')->default(Main::STOCK)->comment('موجود=1 ناموجود=3');
            $table->integer('stock_qty')->default(Main::STATUS_DEFAULT)->comment('تعداد موجودی');
            $table->integer('low_stock')->default(Main::STATUS_DEFAULT)->comment('کمترین مقدار موجودی یا آستانه کم بودن موجودی');
            $table->tinyInteger('sitemap_check')->nullable()->default(Main::STATUS_DEFAULT);
            $table->softDeletes();
            $table->timestamps();
        });
        $products = [
            [
                'title' => 'A14',
                'categories' => 2,
                'slug' => 'A14',
                'author_id' => 1,
                'show_price' => 1,
                'price_type' => 1,
                'manage_stock' => 1,
                'stock_status' => 1,
                'stock_qty' => 8,
                'low_stock' => 2,
                'price' => 250520,
                'price_special' => 240420,
                'price_currency' => 0,
                'price_currency_special' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'A34',
                'categories' => 2,
                'slug' => 'A34',
                'author_id' => 1,
                'show_price' => 1,
                'price_type' => 1,
                'manage_stock' => 1,
                'stock_status' => 1,
                'stock_qty' => 10,
                'low_stock' => 1,
                'price' => 750000,
                'price_special' => 650000,
                'price_currency' => 0,
                'price_currency_special' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Legion',
                'categories' => 3,
                'slug' => 'Legion',
                'author_id' => 1,
                'show_price' => 1,
                'price_type' => 2,
                'manage_stock' => 3,
                'stock_status' => 1,
                'stock_qty' => 0,
                'low_stock' => 0,
                'price' => 0,
                'price_special' => 0,
                'price_currency' => 15.25,
                'price_currency_special' => 14.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('products')->insert($products);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
