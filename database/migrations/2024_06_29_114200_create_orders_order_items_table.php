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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('نام سفارش دهنده');
            $table->float('tax')->default(Main::STATUS_DEFAULT);

            $table->foreignId('delivery_id')->nullable()
                ->constrained(table: 'deliveries', indexName: 'orders_delivery_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->float('delivery_price')->nullable()->default(0);

            $table->foreignId('delivery_discount_id')->nullable()
                ->constrained(table: 'discounts', indexName: 'orders_delivery_discount_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->float('delivery_discount')->nullable()->default(0);
            $table->float('delivery_total')->nullable()->default(0);
            $table->text('delivery_description')->nullable();
            $table->foreignId('discount_id')->nullable()
                ->constrained(table: 'discounts', indexName: 'orders_discount_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->float('total_price')->default(Main::STATUS_DEFAULT)->comment('قیمت آیتم ها');
            $table->float('total_discount')->default(Main::STATUS_DEFAULT)->comment('تخفیف آیتم ها');

            $table->float('discount')->nullable()->default(0)->comment('تخفیف سفارش');
            $table->float('total')->default(Main::STATUS_DEFAULT)->comment('قیمت کل سفارش بعد از کسر تخفیف و جمع مالیات و ارسال');
            $table->foreignId('address_id')->nullable()
                ->constrained(table: 'addresses', indexName: 'orders_address_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->tinyInteger('payment_status')->default(Main::STATUS_DEFAULT);
            $table->string('ip')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile', 11)->nullable();
            $table->string('phone', 11)->nullable();
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'orders_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')->nullable()
                ->constrained(table: 'users', indexName: 'orders_user_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->text('description')->nullable()->comment('توضیحات کاربر برای این سفارش');

            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);

            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('نام محصول');
            $table->foreignId('order_id')->nullable()
                ->constrained(table: 'orders', indexName: 'order_items_order_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->float('qty')->nullable()->default(1);
            $table->float('fee')->nullable()->default(0);
            $table->float('discount')->nullable()->default(0);
            $table->float('total')->nullable()->default(0);
            $table->foreignId('product_id')->nullable()
                ->constrained(table: 'products', indexName: 'order_items_product_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('guest_token')->nullable();
            $table->foreignId('user_id')->nullable()
                ->constrained(table: 'users', indexName: 'order_items_user_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'order_items_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->text('description')->nullable();
            $table->foreignId('discount_id')->nullable()
                ->constrained(table: 'discounts', indexName: 'order_items_discount_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('discount_description')->nullable();

            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
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
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
