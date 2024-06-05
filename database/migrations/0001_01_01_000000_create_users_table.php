<?php

use App\Models\Main;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->nullable()->comment("slug");
            $table->string('email')->unique()->nullable();
            $table->string('mobile', 11)->unique()->nullable();
            $table->string('password');
            $table->tinyInteger('role')->default(Main::ROLE_ADMIN);
            $table->foreignId('user_id')->nullable()->index();
            $table->tinyInteger('type')->default(Main::USER_TYPE_HAGHIGHI)->comment("حقیقی-حقوقی");
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('corporate_name')->nullable();
            $table->tinyInteger('sex')->nullable()->default(Main::USER_SEX_MALE);
            $table->string('mobile_sms', 11)->unique()->nullable();
            $table->string('phone1', 11)->nullable();
            $table->string('phone2', 11)->nullable();
            $table->string('phone3', 11)->nullable();
            $table->string('national_code', 10)->unique()->nullable();
            $table->string('economical_code', 14)->unique()->nullable();
            $table->string('register_code')->unique()->nullable();
            $table->string('website')->nullable();
            $table->date('birthday')->nullable();
            $table->text('description')->nullable()->comment("بیوگرافی");
            $table->string('address')->nullable();
            $table->string('province_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();

            $table->rememberToken();
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });


        //default users
        $users = [
            [
                'first_name' => 'امیر',
                'last_name' => 'عاجلو',
                'password' => Hash::make('Salam123!@'),
                'phone1' => '02188098472',
                'postal_code' => '1468683351',
                'username' => 'amirajloo',
                'email' => 'ajloo.ir@gmail.com',
                'mobile' => '09129247442',
                'national_code' => '0014291789',
                'economical_code' => '00142917890001',
                'birthday' => Carbon::createFromDate(1991, 10, 12),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('users')->insert($users);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
