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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('discount_code')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->default(Main::DISCOUNT_TYPE_PRODUCT);
            $table->tinyInteger('percent')->default(Main::STATUS_DEFAULT);
            $table->float('qty')->default(Main::STATUS_ACTIVE);
            $table->float('fee')->default(Main::STATUS_DEFAULT);
            $table->float('min_order')->default(Main::STATUS_DEFAULT);
            $table->float('min_qty')->default(Main::STATUS_DEFAULT)->comment('مثلا تعداد خرید محصول یک بیشتر از 10 تا بود تخفیف اعمال بشه');
            $table->float('max')->default(Main::STATUS_DEFAULT);
            $table->dateTime('expired_at')->nullable();
            $table->foreignId('product_id')->nullable()
                ->constrained(table: 'products', indexName: 'discounts_items_product_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'discounts_author_id')
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
        Schema::dropIfExists('discounts');
    }
};