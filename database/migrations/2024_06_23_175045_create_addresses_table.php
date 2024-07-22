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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('عنوان آدرس');
            $table->text('description')->nullable()->comment('آدرس');
            $table->string('postal_code')->nullable();
            $table->string('email')->nullable();
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
            $table->foreignId('province_id')->nullable()
                ->constrained(table: 'provinces', indexName: 'addresses_province_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('city_id')->nullable()
                ->constrained(table: 'cities', indexName: 'addresses_city_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('town_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();

        });
        $addresses = [
            [

                'user_id' => 2,
                'title' => "منزل",
                'description' => "شهرک غرب بلوار شهید دادمان",
                'province_id' =>8,
                'city_id' =>301,
                'postal_code' =>"1468683351",
                'email' =>"samiravazife@gmail.com",
                'mobile' =>"09212788597",
                'phone' =>"02188098472",
                'updated_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [

                'user_id' => 2,
                'title' => "شرکت",
                'description' => "میرداماد میدان مادر",
                'province_id' =>8,
                'city_id' =>301,
                'postal_code' =>"1468683351",
                'email' =>"samiravazife@gmail.com",
                'mobile' =>"09212788597",
                'phone' =>"02188098472",
                'updated_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];
        DB::table('addresses')->insert($addresses);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
