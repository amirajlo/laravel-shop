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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile', 11)->nullable();
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
