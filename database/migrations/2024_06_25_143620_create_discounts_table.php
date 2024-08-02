<?php

use App\Models\Main;
use Carbon\Carbon;
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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('discount_code')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->nullable()->default(Main::DISCOUNT_TYPE_PRODUCT);
            $table->tinyInteger('percent')->nullable()->default(Main::STATUS_DEFAULT);
            $table->float('qty')->nullable()->default(Main::STATUS_ACTIVE);
            $table->float('used')->nullable()->default(Main::STATUS_DEFAULT);
            $table->float('fee')->nullable()->default(Main::STATUS_DEFAULT);
            $table->float('min_order')->nullable()->default(Main::STATUS_DEFAULT);
            $table->float('min_qty')->nullable()->default(Main::STATUS_DEFAULT)->comment('مثلا تعداد خرید محصول یک بیشتر از 10 تا بود تخفیف اعمال بشه');
            $table->float('max')->nullable()->default(Main::STATUS_DEFAULT);
            $table->dateTime('expired_at')->nullable();
            $table->foreignId('product_id')->nullable()
                ->constrained(table: 'products', indexName: 'discounts_product_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('cat_id')->nullable()
                ->constrained(table: 'categories', indexName: 'discounts_cat_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('is_deleted')->nullable()->default(Main::STATUS_DISABLED);
            $table->tinyInteger('status')->nullable()->default(Main::STATUS_ACTIVE);
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'discounts_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('discount_used', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discount_id')->nullable()
                ->constrained(table: 'discounts', indexName: 'discount_used_discount_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')->nullable()
                ->constrained(table: 'users', indexName: 'discount_used_user_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();

        });
        $discounts = [
            [
                'title' => 'تخفیف روی محصول 1',
                'discount_code' => 'Ab12HC',
                'type' => Main::DISCOUNT_TYPE_PRODUCT,
                'percent' => 10,
                'fee' => 0,
                'qty' => 10,
                'min_order' => 2,
                'min_qty' => 2,
                'max' => 100000,
                'product_id' => 1,
                'author_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'تخفیف روی محصول 2',
                'discount_code' => 'Ab212HC',
                'type' => Main::DISCOUNT_TYPE_PRODUCT,
                'percent' =>0,
                'fee' => 50000,
                'qty' => 10,
                'min_order' => 2,
                'min_qty' => 2,
                'max' => 100000,
                'product_id' => 2,
                'author_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'تخفیف روی محصول 3',
                'discount_code' => 'A3b212HC',
                'type' => Main::DISCOUNT_TYPE_PRODUCT,
                'percent' =>2,
                'fee' => 50000,
                'qty' => 10,
                'min_order' => 2,
                'min_qty' => 2,
                'max' => 100000,
                'product_id' => 3,
                'author_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'تخفیف روی سفارش',
                'discount_code' => 'Ab112HC',
                'type' => Main::DISCOUNT_TYPE_ORDERS,
                'percent' => 3,
                'fee' => 20000,
                'qty' => 10,
                'min_order' => 2,
                'min_qty' => 2,
                'product_id' => null,
                'max' => 100000,
                'author_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'title' => 'تخفیف روی ارسال',
                'discount_code' => 'DAb113r2HC1',
                'type' => Main::DISCOUNT_TYPE_DELIVERY,
                'percent' => 0,
                'fee' => 25000,
                'qty' => 10,
                'min_order' => 2,
                'min_qty' => 2,
                'product_id' => null,
                'max' => 100000,
                'author_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'تخفیف روی دسته بندی',
                'discount_code' => 'Azw2HC',
                'type' => Main::DISCOUNT_TYPE_CATEGORIES,
                'percent' => 10,
                'fee' => 0,
                'qty' => 10,
                'min_order' => 2,
                'min_qty' => 2,
                'max' => 100000,
                'product_id' => 1,
                'author_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];
        DB::table('discounts')->insert($discounts);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
