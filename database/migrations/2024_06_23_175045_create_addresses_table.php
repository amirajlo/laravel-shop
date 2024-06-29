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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('عنوان آدرس');
            $table->text('description')->nullable()->comment('آدرس');
            $table->string('postal_code')->nullable();
            $table->foreignId('author_id')->nullable()
                ->constrained(table: 'users', indexName: 'addresses_author_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')->nullable()
                ->constrained(table: 'users', indexName: 'addresses_user_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('mobile',11)->nullable();
            $table->string('phone',11)->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('town_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longtitude')->nullable();
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
        Schema::dropIfExists('addresses');
    }
};
