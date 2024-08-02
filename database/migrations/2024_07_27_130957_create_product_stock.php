<?php

use App\Models\Main;
use App\Models\ProductStock;
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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();

            $table->integer('reason')->nullable()->default(ProductStock::REASON_NEW_PRODUCT);
            $table->integer('qty')->default(Main::STATUS_DEFAULT);
            $table->foreignId('item_id')->nullable()
                ->constrained(table: 'order_items', indexName: 'product_stocks_item_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'product_stocks_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product_id')->nullable()
                ->constrained(table: 'products', indexName: 'product_stocks_product_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('status')->default(Main::STOCK_INCREASE);
            $table->timestamps();
        });
        $items=[
            [
                'product_id' => 1,
                'qty' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'qty' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('product_stocks')->insert($items);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
