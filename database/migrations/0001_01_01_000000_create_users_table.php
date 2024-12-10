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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('alpha_2')->nullable();
            $table->string('alpha_3')->nullable();
            $table->string('country_code')->nullable();

            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();
        });

        $countires = [
            ['title' => 'افغانستان'],
            ['title' => 'جزایر آلند'],
            ['title' => 'آلبانی'],
            ['title' => 'الجزایر'],
            ['title' => 'ساموای آمریکا'],
            ['title' => 'آندورا'],
            ['title' => 'آنگولا'],
            ['title' => 'آنگویلا'],
            ['title' => 'جنوبگان'],
            ['title' => 'آنتیگوا و باربودا'],
            ['title' => 'آرژانتین'],
            ['title' => 'ارمنستان'],
            ['title' => 'آروبا'],
            ['title' => 'استرالیا'],
            ['title' => 'اتریش'],
            ['title' => 'جمهوری آذربایجان'],
            ['title' => 'باهاما'],
            ['title' => 'بحرین'],
            ['title' => 'بنگلادش'],
            ['title' => 'باربادوس'],
            ['title' => 'بلاروس'],
            ['title' => 'بلژیک'],
            ['title' => 'بلیز'],
            ['title' => 'بنین'],
            ['title' => 'برمودا'],
            ['title' => 'پادشاهی بوتان'],
            ['title' => 'بولیوی'],
            ['title' => 'بوسنی و هرزگوین'],
            ['title' => 'بوتسوانا'],
            ['title' => 'جزیره بووه'],
            ['title' => 'برزیل'],
            ['title' => 'قلمرو اقیانوس هند بر'],
            ['title' => 'برونئی'],
            ['title' => 'بلغارستان'],
            ['title' => 'بورکینافاسو'],
            ['title' => 'بوروندی'],
            ['title' => 'کامبوج'],
            ['title' => 'کامرون'],
            ['title' => 'کانادا'],
            ['title' => 'کیپ ورد'],
            ['title' => 'جزایر کیمن'],
            ['title' => 'جمهوری آفریقای مرکزی'],
            ['title' => 'چاد'],
            ['title' => 'شیلی'],
            ['title' => 'چین'],
            ['title' => 'جزیره کریسمس'],
            ['title' => 'جزایر کوکوس'],
            ['title' => 'کلمبیا'],
            ['title' => 'کومور'],
            ['title' => 'جمهوری کنگو'],
            ['title' => 'جمهوری دموکراتیک کنگ'],
            ['title' => 'جزایر کوک'],
            ['title' => 'کاستاریکا'],
            ['title' => 'ساحل عاج'],
            ['title' => 'کرواسی'],
            ['title' => 'کوبا'],
            ['title' => 'قبرس'],
            ['title' => 'جمهوری چک'],
            ['title' => 'دانمارک'],
            ['title' => 'جیبوتی'],
            ['title' => 'دومینیکا'],
            ['title' => 'جمهوری دومینیکن'],
            ['title' => 'اکوادور'],
            ['title' => 'مصر'],
            ['title' => 'السالوادور'],
            ['title' => 'گینه استوایی'],
            ['title' => 'اریتره'],
            ['title' => 'استونی'],
            ['title' => 'اتیوپی'],
            ['title' => 'جزایر فالکند'],
            ['title' => 'جزایر فارو'],
            ['title' => 'فیجی'],
            ['title' => 'فنلاند'],
            ['title' => 'فرانسه'],
            ['title' => 'گویان فرانسه'],
            ['title' => 'پولی‌نزی فرانسه'],
            ['title' => 'سرزمین‌های قطب جنوب '],
            ['title' => 'گابون'],
            ['title' => 'گامبیا'],
            ['title' => 'گرجستان'],
            ['title' => 'آلمان'],
            ['title' => 'غنا'],
            ['title' => 'جبل طارق'],
            ['title' => 'یونان'],
            ['title' => 'گرینلند'],
            ['title' => 'گرنادا'],
            ['title' => 'جزیره گوادلوپ'],
            ['title' => 'گوآم'],
            ['title' => 'گواتمالا'],
            ['title' => 'گرنزی'],
            ['title' => 'گینه'],
            ['title' => 'گینه بیسائو'],
            ['title' => 'گویان'],
            ['title' => 'هائیتی'],
            ['title' => 'جزیره هرد و جزایر مک'],
            ['title' => 'واتیکان'],
            ['title' => 'هندوراس'],
            ['title' => 'هنگ کنگ'],
            ['title' => 'مجارستان'],
            ['title' => 'ایسلند'],
            ['title' => 'هند'],
            ['title' => 'اندونزی'],
            ['title' => 'ایران'],

            ['title' => 'عراق'],
            ['title' => 'جمهوری ایرلند'],
            ['title' => 'جزیره من'],
            ['title' => 'اسرائیل'],
            ['title' => 'ایتالیا'],
            ['title' => 'جامائیکا'],
            ['title' => 'ژاپن'],
            ['title' => 'جرسی'],
            ['title' => 'اردن'],
            ['title' => 'قزاقستان'],
            ['title' => 'کنیا'],
            ['title' => 'کیریباتی'],
            ['title' => 'کره شمالی'],
            ['title' => 'کره جنوبی'],
            ['title' => 'کویت'],
            ['title' => 'قرقیزستان'],
            ['title' => 'لائوس'],
            ['title' => 'لتونی'],
            ['title' => 'لبنان'],
            ['title' => 'لسوتو'],
            ['title' => 'لیبریا'],
            ['title' => 'لیختن‌اشتاین'],
            ['title' => 'لیتوانی'],
            ['title' => 'لوکزامبورگ'],
            ['title' => 'ماکائو'],
            ['title' => 'مقدونیه'],
            ['title' => 'ماداگاسکار'],
            ['title' => 'مالاوی'],
            ['title' => 'مالزی'],
            ['title' => 'مالدیو'],
            ['title' => 'مالی'],
            ['title' => 'مالت'],
            ['title' => 'جزایر مارشال'],
            ['title' => 'مارتینیک'],
            ['title' => 'موریتانی'],
            ['title' => 'موریس'],
            ['title' => 'مایوت'],
            ['title' => 'مکزیک'],
            ['title' => 'ایالات فدرال میکرونز'],
            ['title' => 'مولداوی'],
            ['title' => 'موناکو'],
            ['title' => 'مغولستان'],
            ['title' => 'مونته‌نگرو'],
            ['title' => 'مونتسرات'],
            ['title' => 'مراکش'],
            ['title' => 'موزامبیک'],
            ['title' => 'میانمار'],
            ['title' => 'نامیبیا'],
            ['title' => 'نائورو'],
            ['title' => 'نپال'],
            ['title' => 'هلند'],
            ['title' => 'آنتیل هلند'],
            ['title' => 'کالدونیای جدید'],
            ['title' => 'نیوزیلند'],
            ['title' => 'نیکاراگوئه'],
            ['title' => 'نیجر'],
            ['title' => 'نیجریه'],
            ['title' => 'نیووی'],
            ['title' => 'جزیره نورفولک'],
            ['title' => 'جزایر ماریانای شمالی'],
            ['title' => 'نروژ'],
            ['title' => 'عمان'],
            ['title' => 'پاکستان'],
            ['title' => 'پالائو'],
            ['title' => 'فلسطین'],
            ['title' => 'پاناما'],
            ['title' => 'پاپوآ گینه نو'],
            ['title' => 'پاراگوئه'],
            ['title' => 'پرو'],
            ['title' => 'فیلیپین'],
            ['title' => 'جزایر پیت‌کرن'],
            ['title' => 'لهستان'],
            ['title' => 'پرتغال'],
            ['title' => 'پورتوریکو'],
            ['title' => 'قطر'],
            ['title' => 'رئونیون'],
            ['title' => 'رومانی'],
            ['title' => 'روسیه'],
            ['title' => 'رواندا'],
            ['title' => 'سنت بارثلمی'],
            ['title' => 'سینت هلینا'],
            ['title' => 'سنت کیتس و نویس'],
            ['title' => 'سنت لوسیا'],
            ['title' => 'سنت مارتین'],
            ['title' => 'سنت پیر و ماژلان'],
            ['title' => 'سنت وینسنت و گرنادین'],
            ['title' => 'ساموآ'],
            ['title' => 'سن مارینو'],
            ['title' => 'سائوتومه و پرنسیپ'],
            ['title' => 'عربستان سعودی'],
            ['title' => 'سنگال'],
            ['title' => 'صربستان'],
            ['title' => 'سیشل'],
            ['title' => 'سیرالئون'],
            ['title' => 'سنگاپور'],
            ['title' => 'اسلواکی'],
            ['title' => 'اسلوونی'],
            ['title' => 'جزایر سلیمان'],
            ['title' => 'سومالی'],
            ['title' => 'آفریقای جنوبی'],
            ['title' => 'جورجیای جنوبی و جزای'],
            ['title' => 'اسپانیا'],
            ['title' => 'سری‌لانکا'],
            ['title' => 'سودان'],
            ['title' => 'سورینام'],
            ['title' => 'سوالبارد و یان ماین'],
            ['title' => 'سوازیلند'],
            ['title' => 'سوئد'],
            ['title' => 'سوئیس'],
            ['title' => 'سوریه'],
            ['title' => 'تاجیکستان'],
            ['title' => 'تانزانیا'],
            ['title' => 'تایلند'],
            ['title' => 'تیمور شرقی'],
            ['title' => 'توگو'],
            ['title' => 'توکلائو'],
            ['title' => 'تونگا'],
            ['title' => 'ترینیداد و توباگو'],
            ['title' => 'تونس'],
            ['title' => 'ترکیه'],
            ['title' => 'ترکمنستان'],
            ['title' => 'جزایر تورکس و کایکوس'],
            ['title' => 'تووالو'],
            ['title' => 'اوگاندا'],
            ['title' => 'اوکراین'],
            ['title' => 'امارات متحده عربی'],
            ['title' => 'بریتانیا'],
            ['title' => 'ایالات متحده آمریکا'],
            ['title' => 'جزایر کوچک حاشیه‌ای '],
            ['title' => 'اروگوئه'],
            ['title' => 'ازبکستان'],
            ['title' => 'وانواتو'],
            ['title' => 'ونزوئلا'],
            ['title' => 'ویتنام'],
            ['title' => 'جزایر ویرجین انگلستا'],
            ['title' => 'جزایر ویرجین ایالات '],
            ['title' => 'والیس و فوتونا'],
            ['title' => 'صحرای غربی'],
            ['title' => 'یمن'],
            ['title' => 'زامبیا'],
            ['title' => 'زیمبابوه'],
//            [
//                'title' => 'ایران',
//                'alpha_2' => 'IR',
//                'alpha_3' => 'IRN',
//                'country_code' => '364',
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ],
        ];
        DB::table('countries')->insert($countires);


        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('code',3)->nullable();
            $table->foreignId('country_id')->nullable()
                ->constrained(table: 'countries', indexName: 'provinces_country_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();
        });



$provinces = [
    [
        'title' => "آذربایجان شرقی",
        'code' => 03,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "آذربایجان غربی",
        'code' => 04,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "اردبیل",
        'code' => 24,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "اصفهان",
        'code' => 10,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "البرز",
        'code' => 30,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "ایلام",
        'code' => 16,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "بوشهر",
        'code' => 18,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "تهران",
        'code' => 23,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "چهارمحال و بختیاری",
        'code' => 14,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "خراسان جنوبی",
        'code' => 29,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "خراسان رضوی",
        'code' => '09',
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "خراسان شمالی",
        'code' => 28,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "خوزستان",
        'code' => 06,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "زنجان",
        'code' => 19,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "سمنان",
        'code' => 20,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "سیستان و بلوچستان",
        'code' => 11,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "فارس",
        'code' => 07,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "قزوین",
        'code' => 26,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "قم",
        'code' => 25,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "کردستان",
        'code' => 12,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "کرمان",
        'code' => '08',
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "کرمانشاه",
        'code' => 05,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "کهگیلویه و بویراحمد",
        'code' => 17,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "گلستان",
        'code' => 27,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "گیلان",
        'code' => 01,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "لرستان",
        'code' => 02,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "مازندران",
        'code' => 00,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "مرکزی",
        'code' => 11,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "هرمزگان",
        'code' => 22,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "همدان",
        'code' => 13,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
    [
        'title' => "یزد",
        'code' => 21,
        'country_id' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ],
];

        DB::table('provinces')->insert($provinces);



        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();

            $table->foreignId('province_id')->nullable()
                ->constrained(table: 'provinces', indexName: 'cities_province_id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->tinyInteger('status')->default(Main::STATUS_ACTIVE);
            $table->tinyInteger('is_deleted')->default(Main::STATUS_DISABLED);
            $table->softDeletes();
            $table->timestamps();
        });
        $cities = [
            [
                "id" => 1,
                'title' => "اسکو",
                "province_id" => 1
            ],
            [
                "id" => 2,
                'title' => "اهر",
                "province_id" => 1
            ],
            [
                "id" => 3,
                'title' => "ایلخچی",
                "province_id" => 1
            ],
            [
                "id" => 4,
                'title' => "آبش احمد",
                "province_id" => 1
            ],
            [
                "id" => 5,
                'title' => "آذرشهر",
                "province_id" => 1
            ],
            [
                "id" => 6,
                'title' => "آقکند",
                "province_id" => 1
            ],
            [
                "id" => 7,
                'title' => "باسمنج",
                "province_id" => 1
            ],
            [
                "id" => 8,
                'title' => "بخشایش",
                "province_id" => 1
            ],
            [
                "id" => 9,
                'title' => "بستان آباد",
                "province_id" => 1
            ],
            [
                "id" => 10,
                'title' => "بناب",
                "province_id" => 1
            ],
            [
                "id" => 11,
                'title' => "بناب جدید",
                "province_id" => 1
            ],
            [
                "id" => 12,
                'title' => "تبریز",
                "province_id" => 1
            ],
            [
                "id" => 13,
                'title' => "ترک",
                "province_id" => 1
            ],
            [
                "id" => 14,
                'title' => "ترکمانچای",
                "province_id" => 1
            ],
            [
                "id" => 15,
                'title' => "تسوج",
                "province_id" => 1
            ],
            [
                "id" => 16,
                'title' => "تیکمه داش",
                "province_id" => 1
            ],
            [
                "id" => 17,
                'title' => "جلفا",
                "province_id" => 1
            ],
            [
                "id" => 18,
                'title' => "خاروانا",
                "province_id" => 1
            ],
            [
                "id" => 19,
                'title' => "خامنه",
                "province_id" => 1
            ],
            [
                "id" => 20,
                'title' => "خراجو",
                "province_id" => 1
            ],
            [
                "id" => 21,
                'title' => "خسروشهر",
                "province_id" => 1
            ],
            [
                "id" => 22,
                'title' => "خضرلو",
                "province_id" => 1
            ],
            [
                "id" => 23,
                'title' => "خمارلو",
                "province_id" => 1
            ],
            [
                "id" => 24,
                'title' => "خواجه",
                "province_id" => 1
            ],
            [
                "id" => 25,
                'title' => "دوزدوزان",
                "province_id" => 1
            ],
            [
                "id" => 26,
                'title' => "زرنق",
                "province_id" => 1
            ],
            [
                "id" => 27,
                'title' => "زنوز",
                "province_id" => 1
            ],
            [
                "id" => 28,
                'title' => "سراب",
                "province_id" => 1
            ],
            [
                "id" => 29,
                'title' => "سردرود",
                "province_id" => 1
            ],
            [
                "id" => 30,
                'title' => "سهند",
                "province_id" => 1
            ],
            [
                "id" => 31,
                'title' => "سیس",
                "province_id" => 1
            ],
            [
                "id" => 32,
                'title' => "سیه رود",
                "province_id" => 1
            ],
            [
                "id" => 33,
                'title' => "شبستر",
                "province_id" => 1
            ],
            [
                "id" => 34,
                'title' => "شربیان",
                "province_id" => 1
            ],
            [
                "id" => 35,
                'title' => "شرفخانه",
                "province_id" => 1
            ],
            [
                "id" => 36,
                'title' => "شندآباد",
                "province_id" => 1
            ],
            [
                "id" => 37,
                'title' => "صوفیان",
                "province_id" => 1
            ],
            [
                "id" => 38,
                'title' => "عجب شیر",
                "province_id" => 1
            ],
            [
                "id" => 39,
                'title' => "قره آغاج",
                "province_id" => 1
            ],
            [
                "id" => 40,
                'title' => "کشکسرای",
                "province_id" => 1
            ],
            [
                "id" => 41,
                'title' => "کلوانق",
                "province_id" => 1
            ],
            [
                "id" => 42,
                'title' => "کلیبر",
                "province_id" => 1
            ],
            [
                "id" => 43,
                'title' => "کوزه کنان",
                "province_id" => 1
            ],
            [
                "id" => 44,
                'title' => "گوگان",
                "province_id" => 1
            ],
            [
                "id" => 45,
                'title' => "لیلان",
                "province_id" => 1
            ],
            [
                "id" => 46,
                'title' => "مراغه",
                "province_id" => 1
            ],
            [
                "id" => 47,
                'title' => "مرند",
                "province_id" => 1
            ],
            [
                "id" => 48,
                'title' => "ملکان",
                "province_id" => 1
            ],
            [
                "id" => 49,
                'title' => "ملک کیان",
                "province_id" => 1
            ],
            [
                "id" => 50,
                'title' => "ممقان",
                "province_id" => 1
            ],
            [
                "id" => 51,
                'title' => "مهربان",
                "province_id" => 1
            ],
            [
                "id" => 52,
                'title' => "میانه",
                "province_id" => 1
            ],
            [
                "id" => 53,
                'title' => "نظرکهریزی",
                "province_id" => 1
            ],
            [
                "id" => 54,
                'title' => "هادی شهر",
                "province_id" => 1
            ],
            [
                "id" => 55,
                'title' => "هرگلان",
                "province_id" => 1
            ],
            [
                "id" => 56,
                'title' => "هریس",
                "province_id" => 1
            ],
            [
                "id" => 57,
                'title' => "هشترود",
                "province_id" => 1
            ],
            [
                "id" => 58,
                'title' => "هوراند",
                "province_id" => 1
            ],
            [
                "id" => 59,
                'title' => "وایقان",
                "province_id" => 1
            ],
            [
                "id" => 60,
                'title' => "ورزقان",
                "province_id" => 1
            ],
            [
                "id" => 61,
                'title' => "یامچی",
                "province_id" => 1
            ],
            [
                "id" => 62,
                'title' => "ارومیه",
                "province_id" => 2
            ],
            [
                "id" => 63,
                'title' => "اشنویه",
                "province_id" => 2
            ],
            [
                "id" => 64,
                'title' => "ایواوغلی",
                "province_id" => 2
            ],
            [
                "id" => 65,
                'title' => "آواجیق",
                "province_id" => 2
            ],
            [
                "id" => 66,
                'title' => "باروق",
                "province_id" => 2
            ],
            [
                "id" => 67,
                'title' => "بازرگان",
                "province_id" => 2
            ],
            [
                "id" => 68,
                'title' => "بوکان",
                "province_id" => 2
            ],
            [
                "id" => 69,
                'title' => "پلدشت",
                "province_id" => 2
            ],
            [
                "id" => 70,
                'title' => "پیرانشهر",
                "province_id" => 2
            ],
            [
                "id" => 71,
                'title' => "تازه شهر",
                "province_id" => 2
            ],
            [
                "id" => 72,
                'title' => "تکاب",
                "province_id" => 2
            ],
            [
                "id" => 73,
                'title' => "چهاربرج",
                "province_id" => 2
            ],
            [
                "id" => 74,
                'title' => "خوی",
                "province_id" => 2
            ],
            [
                "id" => 75,
                'title' => "دیزج دیز",
                "province_id" => 2
            ],
            [
                "id" => 76,
                'title' => "ربط",
                "province_id" => 2
            ],
            [
                "id" => 77,
                'title' => "سردشت",
                "province_id" => 2
            ],
            [
                "id" => 78,
                'title' => "سرو",
                "province_id" => 2
            ],
            [
                "id" => 79,
                'title' => "سلماس",
                "province_id" => 2
            ],
            [
                "id" => 80,
                'title' => "سیلوانه",
                "province_id" => 2
            ],
            [
                "id" => 81,
                'title' => "سیمینه",
                "province_id" => 2
            ],
            [
                "id" => 82,
                'title' => "سیه چشمه",
                "province_id" => 2
            ],
            [
                "id" => 83,
                'title' => "شاهین دژ",
                "province_id" => 2
            ],
            [
                "id" => 84,
                'title' => "شوط",
                "province_id" => 2
            ],
            [
                "id" => 85,
                'title' => "فیرورق",
                "province_id" => 2
            ],
            [
                "id" => 86,
                'title' => "قره ضیاءالدین",
                "province_id" => 2
            ],
            [
                "id" => 87,
                'title' => "قطور",
                "province_id" => 2
            ],
            [
                "id" => 88,
                'title' => "قوشچی",
                "province_id" => 2
            ],
            [
                "id" => 89,
                'title' => "کشاورز",
                "province_id" => 2
            ],
            [
                "id" => 90,
                'title' => "گردکشانه",
                "province_id" => 2
            ],
            [
                "id" => 91,
                'title' => "ماکو",
                "province_id" => 2
            ],
            [
                "id" => 92,
                'title' => "محمدیار",
                "province_id" => 2
            ],
            [
                "id" => 93,
                'title' => "محمودآباد",
                "province_id" => 2
            ],
            [
                "id" => 94,
                'title' => "مهاباد",
                "province_id" => 2
            ],
            [
                "id" => 95,
                'title' => "میاندوآب",
                "province_id" => 2
            ],
            [
                "id" => 96,
                'title' => "میرآباد",
                "province_id" => 2
            ],
            [
                "id" => 97,
                'title' => "نالوس",
                "province_id" => 2
            ],
            [
                "id" => 98,
                'title' => "نقده",
                "province_id" => 2
            ],
            [
                "id" => 99,
                'title' => "نوشین",
                "province_id" => 2
            ],
            [
                "id" => 100,
                'title' => "اردبیل",
                "province_id" => 3
            ],
            [
                "id" => 101,
                'title' => "اصلاندوز",
                "province_id" => 3
            ],
            [
                "id" => 102,
                'title' => "آبی بیگلو",
                "province_id" => 3
            ],
            [
                "id" => 103,
                'title' => "بیله سوار",
                "province_id" => 3
            ],
            [
                "id" => 104,
                'title' => "پارس آباد",
                "province_id" => 3
            ],
            [
                "id" => 105,
                'title' => "تازه کند",
                "province_id" => 3
            ],
            [
                "id" => 106,
                'title' => "تازه کندانگوت",
                "province_id" => 3
            ],
            [
                "id" => 107,
                'title' => "جعفرآباد",
                "province_id" => 3
            ],
            [
                "id" => 108,
                'title' => "خلخال",
                "province_id" => 3
            ],
            [
                "id" => 109,
                'title' => "رضی",
                "province_id" => 3
            ],
            [
                "id" => 110,
                'title' => "سرعین",
                "province_id" => 3
            ],
            [
                "id" => 111,
                'title' => "عنبران",
                "province_id" => 3
            ],
            [
                "id" => 112,
                'title' => "فخرآباد",
                "province_id" => 3
            ],
            [
                "id" => 113,
                'title' => "کلور",
                "province_id" => 3
            ],
            [
                "id" => 114,
                'title' => "کوراییم",
                "province_id" => 3
            ],
            [
                "id" => 115,
                'title' => "گرمی",
                "province_id" => 3
            ],
            [
                "id" => 116,
                'title' => "گیوی",
                "province_id" => 3
            ],
            [
                "id" => 117,
                'title' => "لاهرود",
                "province_id" => 3
            ],
            [
                "id" => 118,
                'title' => "مشگین شهر",
                "province_id" => 3
            ],
            [
                "id" => 119,
                'title' => "نمین",
                "province_id" => 3
            ],
            [
                "id" => 120,
                'title' => "نیر",
                "province_id" => 3
            ],
            [
                "id" => 121,
                'title' => "هشتجین",
                "province_id" => 3
            ],
            [
                "id" => 122,
                'title' => "هیر",
                "province_id" => 3
            ],
            [
                "id" => 123,
                'title' => "ابریشم",
                "province_id" => 4
            ],
            [
                "id" => 124,
                'title' => "ابوزیدآباد",
                "province_id" => 4
            ],
            [
                "id" => 125,
                'title' => "اردستان",
                "province_id" => 4
            ],
            [
                "id" => 126,
                'title' => "اژیه",
                "province_id" => 4
            ],
            [
                "id" => 127,
                'title' => "اصفهان",
                "province_id" => 4
            ],
            [
                "id" => 128,
                'title' => "افوس",
                "province_id" => 4
            ],
            [
                "id" => 129,
                'title' => "انارک",
                "province_id" => 4
            ],
            [
                "id" => 130,
                'title' => "ایمانشهر",
                "province_id" => 4
            ],
            [
                "id" => 131,
                'title' => "آران وبیدگل",
                "province_id" => 4
            ],
            [
                "id" => 132,
                'title' => "بادرود",
                "province_id" => 4
            ],
            [
                "id" => 133,
                'title' => "باغ بهادران",
                "province_id" => 4
            ],
            [
                "id" => 134,
                'title' => "بافران",
                "province_id" => 4
            ],
            [
                "id" => 135,
                'title' => "برزک",
                "province_id" => 4
            ],
            [
                "id" => 136,
                'title' => "برف انبار",
                "province_id" => 4
            ],
            [
                "id" => 137,
                'title' => "بهاران شهر",
                "province_id" => 4
            ],
            [
                "id" => 138,
                'title' => "بهارستان",
                "province_id" => 4
            ],
            [
                "id" => 139,
                'title' => "بوئین و میاندشت",
                "province_id" => 4
            ],
            [
                "id" => 140,
                'title' => "پیربکران",
                "province_id" => 4
            ],
            [
                "id" => 141,
                'title' => "تودشک",
                "province_id" => 4
            ],
            [
                "id" => 142,
                'title' => "تیران",
                "province_id" => 4
            ],
            [
                "id" => 143,
                'title' => "جندق",
                "province_id" => 4
            ],
            [
                "id" => 144,
                'title' => "جوزدان",
                "province_id" => 4
            ],
            [
                "id" => 145,
                'title' => "جوشقان و کامو",
                "province_id" => 4
            ],
            [
                "id" => 146,
                'title' => "چادگان",
                "province_id" => 4
            ],
            [
                "id" => 147,
                'title' => "چرمهین",
                "province_id" => 4
            ],
            [
                "id" => 148,
                'title' => "چمگردان",
                "province_id" => 4
            ],
            [
                "id" => 149,
                'title' => "حبیب آباد",
                "province_id" => 4
            ],
            [
                "id" => 150,
                'title' => "حسن آباد",
                "province_id" => 4
            ],
            [
                "id" => 151,
                'title' => "حنا",
                "province_id" => 4
            ],
            [
                "id" => 152,
                'title' => "خالدآباد",
                "province_id" => 4
            ],
            [
                "id" => 153,
                'title' => "خمینی شهر",
                "province_id" => 4
            ],
            [
                "id" => 154,
                'title' => "خوانسار",
                "province_id" => 4
            ],
            [
                "id" => 155,
                'title' => "خور",
                "province_id" => 4
            ],
            [
                "id" => 157,
                'title' => "خورزوق",
                "province_id" => 4
            ],
            [
                "id" => 158,
                'title' => "داران",
                "province_id" => 4
            ],
            [
                "id" => 159,
                'title' => "دامنه",
                "province_id" => 4
            ],
            [
                "id" => 160,
                'title' => "درچه",
                "province_id" => 4
            ],
            [
                "id" => 161,
                'title' => "دستگرد",
                "province_id" => 4
            ],
            [
                "id" => 162,
                'title' => "دهاقان",
                "province_id" => 4
            ],
            [
                "id" => 163,
                'title' => "دهق",
                "province_id" => 4
            ],
            [
                "id" => 164,
                'title' => "دولت آباد",
                "province_id" => 4
            ],
            [
                "id" => 165,
                'title' => "دیزیچه",
                "province_id" => 4
            ],
            [
                "id" => 166,
                'title' => "رزوه",
                "province_id" => 4
            ],
            [
                "id" => 167,
                'title' => "رضوانشهر",
                "province_id" => 4
            ],
            [
                "id" => 168,
                'title' => "زاینده رود",
                "province_id" => 4
            ],
            [
                "id" => 169,
                'title' => "زرین شهر",
                "province_id" => 4
            ],
            [
                "id" => 170,
                'title' => "زواره",
                "province_id" => 4
            ],
            [
                "id" => 171,
                'title' => "زیباشهر",
                "province_id" => 4
            ],
            [
                "id" => 172,
                'title' => "سده لنجان",
                "province_id" => 4
            ],
            [
                "id" => 173,
                'title' => "سفیدشهر",
                "province_id" => 4
            ],
            [
                "id" => 174,
                'title' => "سگزی",
                "province_id" => 4
            ],
            [
                "id" => 175,
                'title' => "سمیرم",
                "province_id" => 4
            ],
            [
                "id" => 176,
                'title' => "شاهین شهر",
                "province_id" => 4
            ],
            [
                "id" => 177,
                'title' => "شهرضا",
                "province_id" => 4
            ],
            [
                "id" => 178,
                'title' => "طالخونچه",
                "province_id" => 4
            ],
            [
                "id" => 179,
                'title' => "عسگران",
                "province_id" => 4
            ],
            [
                "id" => 180,
                'title' => "علویجه",
                "province_id" => 4
            ],
            [
                "id" => 181,
                'title' => "فرخی",
                "province_id" => 4
            ],
            [
                "id" => 182,
                'title' => "فریدونشهر",
                "province_id" => 4
            ],
            [
                "id" => 183,
                'title' => "فلاورجان",
                "province_id" => 4
            ],
            [
                "id" => 184,
                'title' => "فولادشهر",
                "province_id" => 4
            ],
            [
                "id" => 185,
                'title' => "قمصر",
                "province_id" => 4
            ],
            [
                "id" => 186,
                'title' => "قهجاورستان",
                "province_id" => 4
            ],
            [
                "id" => 187,
                'title' => "قهدریجان",
                "province_id" => 4
            ],
            [
                "id" => 188,
                'title' => "کاشان",
                "province_id" => 4
            ],
            [
                "id" => 189,
                'title' => "کرکوند",
                "province_id" => 4
            ],
            [
                "id" => 190,
                'title' => "کلیشاد و سودرجان",
                "province_id" => 4
            ],
            [
                "id" => 191,
                'title' => "کمشچه",
                "province_id" => 4
            ],
            [
                "id" => 192,
                'title' => "کمه",
                "province_id" => 4
            ],
            [
                "id" => 193,
                'title' => "کهریزسنگ",
                "province_id" => 4
            ],
            [
                "id" => 194,
                'title' => "کوشک",
                "province_id" => 4
            ],
            [
                "id" => 195,
                'title' => "کوهپایه",
                "province_id" => 4
            ],
            [
                "id" => 196,
                'title' => "گرگاب",
                "province_id" => 4
            ],
            [
                "id" => 197,
                'title' => "گزبرخوار",
                "province_id" => 4
            ],
            [
                "id" => 198,
                'title' => "گلپایگان",
                "province_id" => 4
            ],
            [
                "id" => 199,
                'title' => "گلدشت",
                "province_id" => 4
            ],
            [
                "id" => 200,
                'title' => "گلشهر",
                "province_id" => 4
            ],
            [
                "id" => 201,
                'title' => "گوگد",
                "province_id" => 4
            ],
            [
                "id" => 202,
                'title' => "لای بید",
                "province_id" => 4
            ],
            [
                "id" => 203,
                'title' => "مبارکه",
                "province_id" => 4
            ],
            [
                "id" => 204,
                'title' => "مجلسی",
                "province_id" => 4
            ],
            [
                "id" => 205,
                'title' => "محمدآباد",
                "province_id" => 4
            ],
            [
                "id" => 206,
                'title' => "مشکات",
                "province_id" => 4
            ],
            [
                "id" => 207,
                'title' => "منظریه",
                "province_id" => 4
            ],
            [
                "id" => 208,
                'title' => "مهاباد",
                "province_id" => 4
            ],
            [
                "id" => 209,
                'title' => "میمه",
                "province_id" => 4
            ],
            [
                "id" => 210,
                'title' => "نائین",
                "province_id" => 4
            ],
            [
                "id" => 211,
                'title' => "نجف آباد",
                "province_id" => 4
            ],
            [
                "id" => 212,
                'title' => "نصرآباد",
                "province_id" => 4
            ],
            [
                "id" => 213,
                'title' => "نطنز",
                "province_id" => 4
            ],
            [
                "id" => 214,
                'title' => "نوش آباد",
                "province_id" => 4
            ],
            [
                "id" => 215,
                'title' => "نیاسر",
                "province_id" => 4
            ],
            [
                "id" => 216,
                'title' => "نیک آباد",
                "province_id" => 4
            ],
            [
                "id" => 217,
                'title' => "هرند",
                "province_id" => 4
            ],
            [
                "id" => 218,
                'title' => "ورزنه",
                "province_id" => 4
            ],
            [
                "id" => 219,
                'title' => "ورنامخواست",
                "province_id" => 4
            ],
            [
                "id" => 220,
                'title' => "وزوان",
                "province_id" => 4
            ],
            [
                "id" => 221,
                'title' => "ونک",
                "province_id" => 4
            ],
            [
                "id" => 222,
                'title' => "اسارا",
                "province_id" => 5
            ],
            [
                "id" => 223,
                'title' => "اشتهارد",
                "province_id" => 5
            ],
            [
                "id" => 224,
                'title' => "تنکمان",
                "province_id" => 5
            ],
            [
                "id" => 225,
                'title' => "چهارباغ",
                "province_id" => 5
            ],
            [
                "id" => 226,
                'title' => "سعید آباد",
                "province_id" => 5
            ],
            [
                "id" => 227,
                'title' => "شهر جدید هشتگرد",
                "province_id" => 5
            ],
            [
                "id" => 228,
                'title' => "طالقان",
                "province_id" => 5
            ],
            [
                "id" => 229,
                'title' => "کرج",
                "province_id" => 5
            ],
            [
                "id" => 230,
                'title' => "کمال شهر",
                "province_id" => 5
            ],
            [
                "id" => 231,
                'title' => "کوهسار",
                "province_id" => 5
            ],
            [
                "id" => 232,
                'title' => "گرمدره",
                "province_id" => 5
            ],
            [
                "id" => 233,
                'title' => "ماهدشت",
                "province_id" => 5
            ],
            [
                "id" => 234,
                'title' => "محمدشهر",
                "province_id" => 5
            ],
            [
                "id" => 235,
                'title' => "مشکین دشت",
                "province_id" => 5
            ],
            [
                "id" => 236,
                'title' => "نظرآباد",
                "province_id" => 5
            ],
            [
                "id" => 237,
                'title' => "هشتگرد",
                "province_id" => 5
            ],
            [
                "id" => 238,
                'title' => "ارکواز",
                "province_id" => 6
            ],
            [
                "id" => 239,
                'title' => "ایلام",
                "province_id" => 6
            ],
            [
                "id" => 240,
                'title' => "ایوان",
                "province_id" => 6
            ],
            [
                "id" => 241,
                'title' => "آبدانان",
                "province_id" => 6
            ],
            [
                "id" => 242,
                'title' => "آسمان آباد",
                "province_id" => 6
            ],
            [
                "id" => 243,
                'title' => "بدره",
                "province_id" => 6
            ],
            [
                "id" => 244,
                'title' => "پهله",
                "province_id" => 6
            ],
            [
                "id" => 245,
                'title' => "توحید",
                "province_id" => 6
            ],
            [
                "id" => 246,
                'title' => "چوار",
                "province_id" => 6
            ],
            [
                "id" => 247,
                'title' => "دره شهر",
                "province_id" => 6
            ],
            [
                "id" => 248,
                'title' => "دلگشا",
                "province_id" => 6
            ],
            [
                "id" => 249,
                'title' => "دهلران",
                "province_id" => 6
            ],
            [
                "id" => 250,
                'title' => "زرنه",
                "province_id" => 6
            ],
            [
                "id" => 251,
                'title' => "سراب باغ",
                "province_id" => 6
            ],
            [
                "id" => 252,
                'title' => "سرابله",
                "province_id" => 6
            ],
            [
                "id" => 253,
                'title' => "صالح آباد",
                "province_id" => 6
            ],
            [
                "id" => 254,
                'title' => "لومار",
                "province_id" => 6
            ],
            [
                "id" => 255,
                'title' => "مهران",
                "province_id" => 6
            ],
            [
                "id" => 256,
                'title' => "مورموری",
                "province_id" => 6
            ],
            [
                "id" => 257,
                'title' => "موسیان",
                "province_id" => 6
            ],
            [
                "id" => 258,
                'title' => "میمه",
                "province_id" => 6
            ],
            [
                "id" => 259,
                'title' => "امام حسن",
                "province_id" => 7
            ],
            [
                "id" => 260,
                'title' => "انارستان",
                "province_id" => 7
            ],
            [
                "id" => 261,
                'title' => "اهرم",
                "province_id" => 7
            ],
            [
                "id" => 262,
                'title' => "آب پخش",
                "province_id" => 7
            ],
            [
                "id" => 263,
                'title' => "آبدان",
                "province_id" => 7
            ],
            [
                "id" => 264,
                'title' => "برازجان",
                "province_id" => 7
            ],
            [
                "id" => 265,
                'title' => "بردخون",
                "province_id" => 7
            ],
            [
                "id" => 266,
                'title' => "بندردیر",
                "province_id" => 7
            ],
            [
                "id" => 267,
                'title' => "بندردیلم",
                "province_id" => 7
            ],
            [
                "id" => 268,
                'title' => "بندرریگ",
                "province_id" => 7
            ],
            [
                "id" => 269,
                'title' => "بندرکنگان",
                "province_id" => 7
            ],
            [
                "id" => 270,
                'title' => "بندرگناوه",
                "province_id" => 7
            ],
            [
                "id" => 271,
                'title' => "بنک",
                "province_id" => 7
            ],
            [
                "id" => 272,
                'title' => "بوشهر",
                "province_id" => 7
            ],
            [
                "id" => 273,
                'title' => "تنگ ارم",
                "province_id" => 7
            ],
            [
                "id" => 274,
                'title' => "جم",
                "province_id" => 7
            ],
            [
                "id" => 275,
                'title' => "چغادک",
                "province_id" => 7
            ],
            [
                "id" => 276,
                'title' => "خارک",
                "province_id" => 7
            ],
            [
                "id" => 277,
                'title' => "خورموج",
                "province_id" => 7
            ],
            [
                "id" => 278,
                'title' => "دالکی",
                "province_id" => 7
            ],
            [
                "id" => 279,
                'title' => "دلوار",
                "province_id" => 7
            ],
            [
                "id" => 280,
                'title' => "ریز",
                "province_id" => 7
            ],
            [
                "id" => 281,
                'title' => "سعدآباد",
                "province_id" => 7
            ],
            [
                "id" => 282,
                'title' => "سیراف",
                "province_id" => 7
            ],
            [
                "id" => 283,
                'title' => "شبانکاره",
                "province_id" => 7
            ],
            [
                "id" => 284,
                'title' => "شنبه",
                "province_id" => 7
            ],
            [
                "id" => 285,
                'title' => "عسلویه",
                "province_id" => 7
            ],
            [
                "id" => 286,
                'title' => "کاکی",
                "province_id" => 7
            ],
            [
                "id" => 287,
                'title' => "کلمه",
                "province_id" => 7
            ],
            [
                "id" => 288,
                'title' => "نخل تقی",
                "province_id" => 7
            ],
            [
                "id" => 289,
                'title' => "وحدتیه",
                "province_id" => 7
            ],
            [
                "id" => 290,
                'title' => "ارجمند",
                "province_id" => 8
            ],
            [
                "id" => 291,
                'title' => "اسلامشهر",
                "province_id" => 8
            ],
            [
                "id" => 292,
                'title' => "اندیشه",
                "province_id" => 8
            ],
            [
                "id" => 293,
                'title' => "آبسرد",
                "province_id" => 8
            ],
            [
                "id" => 294,
                'title' => "آبعلی",
                "province_id" => 8
            ],
            [
                "id" => 295,
                'title' => "باغستان",
                "province_id" => 8
            ],
            [
                "id" => 296,
                'title' => "باقرشهر",
                "province_id" => 8
            ],
            [
                "id" => 297,
                'title' => "بومهن",
                "province_id" => 8
            ],
            [
                "id" => 298,
                'title' => "پاکدشت",
                "province_id" => 8
            ],
            [
                "id" => 299,
                'title' => "پردیس",
                "province_id" => 8
            ],
            [
                "id" => 300,
                'title' => "پیشوا",
                "province_id" => 8
            ],
            [
                "id" => 301,
                'title' => "تهران",
                "province_id" => 8
            ],
            [
                "id" => 302,
                'title' => "جوادآباد",
                "province_id" => 8
            ],
            [
                "id" => 303,
                'title' => "چهاردانگه",
                "province_id" => 8
            ],
            [
                "id" => 304,
                'title' => "حسن آباد",
                "province_id" => 8
            ],
            [
                "id" => 305,
                'title' => "دماوند",
                "province_id" => 8
            ],
            [
                "id" => 306,
                'title' => "دیزین",
                "province_id" => 8
            ],
            [
                "id" => 307,
                'title' => "شهر ری",
                "province_id" => 8
            ],
            [
                "id" => 308,
                'title' => "رباط کریم",
                "province_id" => 8
            ],
            [
                "id" => 309,
                'title' => "رودهن",
                "province_id" => 8
            ],
            [
                "id" => 310,
                'title' => "شاهدشهر",
                "province_id" => 8
            ],
            [
                "id" => 311,
                'title' => "شریف آباد",
                "province_id" => 8
            ],
            [
                "id" => 312,
                'title' => "شمشک",
                "province_id" => 8
            ],
            [
                "id" => 313,
                'title' => "شهریار",
                "province_id" => 8
            ],
            [
                "id" => 314,
                'title' => "صالح آباد",
                "province_id" => 8
            ],
            [
                "id" => 315,
                'title' => "صباشهر",
                "province_id" => 8
            ],
            [
                "id" => 316,
                'title' => "صفادشت",
                "province_id" => 8
            ],
            [
                "id" => 317,
                'title' => "فردوسیه",
                "province_id" => 8
            ],
            [
                "id" => 318,
                'title' => "فشم",
                "province_id" => 8
            ],
            [
                "id" => 319,
                'title' => "فیروزکوه",
                "province_id" => 8
            ],
            [
                "id" => 320,
                'title' => "قدس",
                "province_id" => 8
            ],
            [
                "id" => 321,
                'title' => "قرچک",
                "province_id" => 8
            ],
            [
                "id" => 322,
                'title' => "کهریزک",
                "province_id" => 8
            ],
            [
                "id" => 323,
                'title' => "کیلان",
                "province_id" => 8
            ],
            [
                "id" => 324,
                'title' => "گلستان",
                "province_id" => 8
            ],
            [
                "id" => 325,
                'title' => "لواسان",
                "province_id" => 8
            ],
            [
                "id" => 326,
                'title' => "ملارد",
                "province_id" => 8
            ],
            [
                "id" => 327,
                'title' => "میگون",
                "province_id" => 8
            ],
            [
                "id" => 328,
                'title' => "نسیم شهر",
                "province_id" => 8
            ],
            [
                "id" => 329,
                'title' => "نصیرآباد",
                "province_id" => 8
            ],
            [
                "id" => 330,
                'title' => "وحیدیه",
                "province_id" => 8
            ],
            [
                "id" => 331,
                'title' => "ورامین",
                "province_id" => 8
            ],
            [
                "id" => 332,
                'title' => "اردل",
                "province_id" => 9
            ],
            [
                "id" => 333,
                'title' => "آلونی",
                "province_id" => 9
            ],
            [
                "id" => 334,
                'title' => "باباحیدر",
                "province_id" => 9
            ],
            [
                "id" => 335,
                'title' => "بروجن",
                "province_id" => 9
            ],
            [
                "id" => 336,
                'title' => "بلداجی",
                "province_id" => 9
            ],
            [
                "id" => 337,
                'title' => "بن",
                "province_id" => 9
            ],
            [
                "id" => 338,
                'title' => "جونقان",
                "province_id" => 9
            ],
            [
                "id" => 339,
                'title' => "چلگرد",
                "province_id" => 9
            ],
            [
                "id" => 340,
                'title' => "سامان",
                "province_id" => 9
            ],
            [
                "id" => 341,
                'title' => "سفیددشت",
                "province_id" => 9
            ],
            [
                "id" => 342,
                'title' => "سودجان",
                "province_id" => 9
            ],
            [
                "id" => 343,
                'title' => "سورشجان",
                "province_id" => 9
            ],
            [
                "id" => 344,
                'title' => "شلمزار",
                "province_id" => 9
            ],
            [
                "id" => 345,
                'title' => "شهرکرد",
                "province_id" => 9
            ],
            [
                "id" => 346,
                'title' => "طاقانک",
                "province_id" => 9
            ],
            [
                "id" => 347,
                'title' => "فارسان",
                "province_id" => 9
            ],
            [
                "id" => 348,
                'title' => "فرادنبه",
                "province_id" => 9
            ],
            [
                "id" => 349,
                'title' => "فرخ شهر",
                "province_id" => 9
            ],
            [
                "id" => 350,
                'title' => "کیان",
                "province_id" => 9
            ],
            [
                "id" => 351,
                'title' => "گندمان",
                "province_id" => 9
            ],
            [
                "id" => 352,
                'title' => "گهرو",
                "province_id" => 9
            ],
            [
                "id" => 353,
                'title' => "لردگان",
                "province_id" => 9
            ],
            [
                "id" => 354,
                'title' => "مال خلیفه",
                "province_id" => 9
            ],
            [
                "id" => 355,
                'title' => "ناغان",
                "province_id" => 9
            ],
            [
                "id" => 356,
                'title' => "نافچ",
                "province_id" => 9
            ],
            [
                "id" => 357,
                'title' => "نقنه",
                "province_id" => 9
            ],
            [
                "id" => 358,
                'title' => "هفشجان",
                "province_id" => 9
            ],
            [
                "id" => 359,
                'title' => "ارسک",
                "province_id" => 10
            ],
            [
                "id" => 360,
                'title' => "اسدیه",
                "province_id" => 10
            ],
            [
                "id" => 361,
                'title' => "اسفدن",
                "province_id" => 10
            ],
            [
                "id" => 362,
                'title' => "اسلامیه",
                "province_id" => 10
            ],
            [
                "id" => 363,
                'title' => "آرین شهر",
                "province_id" => 10
            ],
            [
                "id" => 364,
                'title' => "آیسک",
                "province_id" => 10
            ],
            [
                "id" => 365,
                'title' => "بشرویه",
                "province_id" => 10
            ],
            [
                "id" => 366,
                'title' => "بیرجند",
                "province_id" => 10
            ],
            [
                "id" => 367,
                'title' => "حاجی آباد",
                "province_id" => 10
            ],
            [
                "id" => 368,
                'title' => "خضری دشت بیاض",
                "province_id" => 10
            ],
            [
                "id" => 369,
                'title' => "خوسف",
                "province_id" => 10
            ],
            [
                "id" => 370,
                'title' => "زهان",
                "province_id" => 10
            ],
            [
                "id" => 371,
                'title' => "سرایان",
                "province_id" => 10
            ],
            [
                "id" => 372,
                'title' => "سربیشه",
                "province_id" => 10
            ],
            [
                "id" => 373,
                'title' => "سه قلعه",
                "province_id" => 10
            ],
            [
                "id" => 374,
                'title' => "شوسف",
                "province_id" => 10
            ],
            [
                "id" => 375,
                'title' => "طبس ",
                "province_id" => 10
            ],
            [
                "id" => 376,
                'title' => "فردوس",
                "province_id" => 10
            ],
            [
                "id" => 377,
                'title' => "قاین",
                "province_id" => 10
            ],
            [
                "id" => 378,
                'title' => "قهستان",
                "province_id" => 10
            ],
            [
                "id" => 379,
                'title' => "محمدشهر",
                "province_id" => 10
            ],
            [
                "id" => 380,
                'title' => "مود",
                "province_id" => 10
            ],
            [
                "id" => 381,
                'title' => "نهبندان",
                "province_id" => 10
            ],
            [
                "id" => 382,
                'title' => "نیمبلوک",
                "province_id" => 10
            ],
            [
                "id" => 383,
                'title' => "احمدآباد صولت",
                "province_id" => 11
            ],
            [
                "id" => 384,
                'title' => "انابد",
                "province_id" => 11
            ],
            [
                "id" => 385,
                'title' => "باجگیران",
                "province_id" => 11
            ],
            [
                "id" => 386,
                'title' => "باخرز",
                "province_id" => 11
            ],
            [
                "id" => 387,
                'title' => "بار",
                "province_id" => 11
            ],
            [
                "id" => 388,
                'title' => "بایگ",
                "province_id" => 11
            ],
            [
                "id" => 389,
                'title' => "بجستان",
                "province_id" => 11
            ],
            [
                "id" => 390,
                'title' => "بردسکن",
                "province_id" => 11
            ],
            [
                "id" => 391,
                'title' => "بیدخت",
                "province_id" => 11
            ],
            [
                "id" => 392,
                'title' => "تایباد",
                "province_id" => 11
            ],
            [
                "id" => 393,
                'title' => "تربت جام",
                "province_id" => 11
            ],
            [
                "id" => 394,
                'title' => "تربت حیدریه",
                "province_id" => 11
            ],
            [
                "id" => 395,
                'title' => "جغتای",
                "province_id" => 11
            ],
            [
                "id" => 396,
                'title' => "جنگل",
                "province_id" => 11
            ],
            [
                "id" => 397,
                'title' => "چاپشلو",
                "province_id" => 11
            ],
            [
                "id" => 398,
                'title' => "چکنه",
                "province_id" => 11
            ],
            [
                "id" => 399,
                'title' => "چناران",
                "province_id" => 11
            ],
            [
                "id" => 400,
                'title' => "خرو",
                "province_id" => 11
            ],
            [
                "id" => 401,
                'title' => "خلیل آباد",
                "province_id" => 11
            ],
            [
                "id" => 402,
                'title' => "خواف",
                "province_id" => 11
            ],
            [
                "id" => 403,
                'title' => "داورزن",
                "province_id" => 11
            ],
            [
                "id" => 404,
                'title' => "درگز",
                "province_id" => 11
            ],
            [
                "id" => 405,
                'title' => "در رود",
                "province_id" => 11
            ],
            [
                "id" => 406,
                'title' => "دولت آباد",
                "province_id" => 11
            ],
            [
                "id" => 407,
                'title' => "رباط سنگ",
                "province_id" => 11
            ],
            [
                "id" => 408,
                'title' => "رشتخوار",
                "province_id" => 11
            ],
            [
                "id" => 409,
                'title' => "رضویه",
                "province_id" => 11
            ],
            [
                "id" => 410,
                'title' => "روداب",
                "province_id" => 11
            ],
            [
                "id" => 411,
                'title' => "ریوش",
                "province_id" => 11
            ],
            [
                "id" => 412,
                'title' => "سبزوار",
                "province_id" => 11
            ],
            [
                "id" => 413,
                'title' => "سرخس",
                "province_id" => 11
            ],
            [
                "id" => 414,
                'title' => "سفیدسنگ",
                "province_id" => 11
            ],
            [
                "id" => 415,
                'title' => "سلامی",
                "province_id" => 11
            ],
            [
                "id" => 416,
                'title' => "سلطان آباد",
                "province_id" => 11
            ],
            [
                "id" => 417,
                'title' => "سنگان",
                "province_id" => 11
            ],
            [
                "id" => 418,
                'title' => "شادمهر",
                "province_id" => 11
            ],
            [
                "id" => 419,
                'title' => "شاندیز",
                "province_id" => 11
            ],
            [
                "id" => 420,
                'title' => "ششتمد",
                "province_id" => 11
            ],
            [
                "id" => 421,
                'title' => "شهرآباد",
                "province_id" => 11
            ],
            [
                "id" => 422,
                'title' => "شهرزو",
                "province_id" => 11
            ],
            [
                "id" => 423,
                'title' => "صالح آباد",
                "province_id" => 11
            ],
            [
                "id" => 424,
                'title' => "طرقبه",
                "province_id" => 11
            ],
            [
                "id" => 425,
                'title' => "عشق آباد",
                "province_id" => 11
            ],
            [
                "id" => 426,
                'title' => "فرهادگرد",
                "province_id" => 11
            ],
            [
                "id" => 427,
                'title' => "فریمان",
                "province_id" => 11
            ],
            [
                "id" => 428,
                'title' => "فیروزه",
                "province_id" => 11
            ],
            [
                "id" => 429,
                'title' => "فیض آباد",
                "province_id" => 11
            ],
            [
                "id" => 430,
                'title' => "قاسم آباد",
                "province_id" => 11
            ],
            [
                "id" => 431,
                'title' => "قدمگاه",
                "province_id" => 11
            ],
            [
                "id" => 432,
                'title' => "قلندرآباد",
                "province_id" => 11
            ],
            [
                "id" => 433,
                'title' => "قوچان",
                "province_id" => 11
            ],
            [
                "id" => 434,
                'title' => "کاخک",
                "province_id" => 11
            ],
            [
                "id" => 435,
                'title' => "کاریز",
                "province_id" => 11
            ],
            [
                "id" => 436,
                'title' => "کاشمر",
                "province_id" => 11
            ],
            [
                "id" => 437,
                'title' => "کدکن",
                "province_id" => 11
            ],
            [
                "id" => 438,
                'title' => "کلات",
                "province_id" => 11
            ],
            [
                "id" => 439,
                'title' => "کندر",
                "province_id" => 11
            ],
            [
                "id" => 440,
                'title' => "گلمکان",
                "province_id" => 11
            ],
            [
                "id" => 441,
                'title' => "گناباد",
                "province_id" => 11
            ],
            [
                "id" => 442,
                'title' => "لطف آباد",
                "province_id" => 11
            ],
            [
                "id" => 443,
                'title' => "مزدآوند",
                "province_id" => 11
            ],
            [
                "id" => 444,
                'title' => "مشهد",
                "province_id" => 11
            ],
            [
                "id" => 445,
                'title' => "ملک آباد",
                "province_id" => 11
            ],
            [
                "id" => 446,
                'title' => "نشتیفان",
                "province_id" => 11
            ],
            [
                "id" => 447,
                'title' => "نصرآباد",
                "province_id" => 11
            ],
            [
                "id" => 448,
                'title' => "نقاب",
                "province_id" => 11
            ],
            [
                "id" => 449,
                'title' => "نوخندان",
                "province_id" => 11
            ],
            [
                "id" => 450,
                'title' => "نیشابور",
                "province_id" => 11
            ],
            [
                "id" => 451,
                'title' => "نیل شهر",
                "province_id" => 11
            ],
            [
                "id" => 452,
                'title' => "همت آباد",
                "province_id" => 11
            ],
            [
                "id" => 453,
                'title' => "یونسی",
                "province_id" => 11
            ],
            [
                "id" => 454,
                'title' => "اسفراین",
                "province_id" => 12
            ],
            [
                "id" => 455,
                'title' => "ایور",
                "province_id" => 12
            ],
            [
                "id" => 456,
                'title' => "آشخانه",
                "province_id" => 12
            ],
            [
                "id" => 457,
                'title' => "بجنورد",
                "province_id" => 12
            ],
            [
                "id" => 458,
                'title' => "پیش قلعه",
                "province_id" => 12
            ],
            [
                "id" => 459,
                'title' => "تیتکانلو",
                "province_id" => 12
            ],
            [
                "id" => 460,
                'title' => "جاجرم",
                "province_id" => 12
            ],
            [
                "id" => 461,
                'title' => "حصارگرمخان",
                "province_id" => 12
            ],
            [
                "id" => 462,
                'title' => "درق",
                "province_id" => 12
            ],
            [
                "id" => 463,
                'title' => "راز",
                "province_id" => 12
            ],
            [
                "id" => 464,
                'title' => "سنخواست",
                "province_id" => 12
            ],
            [
                "id" => 465,
                'title' => "شوقان",
                "province_id" => 12
            ],
            [
                "id" => 466,
                'title' => "شیروان",
                "province_id" => 12
            ],
            [
                "id" => 467,
                'title' => "صفی آباد",
                "province_id" => 12
            ],
            [
                "id" => 468,
                'title' => "فاروج",
                "province_id" => 12
            ],
            [
                "id" => 469,
                'title' => "قاضی",
                "province_id" => 12
            ],
            [
                "id" => 470,
                'title' => "گرمه",
                "province_id" => 12
            ],
            [
                "id" => 471,
                'title' => "لوجلی",
                "province_id" => 12
            ],
            [
                "id" => 472,
                'title' => "اروندکنار",
                "province_id" => 13
            ],
            [
                "id" => 473,
                'title' => "الوان",
                "province_id" => 13
            ],
            [
                "id" => 474,
                'title' => "امیدیه",
                "province_id" => 13
            ],
            [
                "id" => 475,
                'title' => "اندیمشک",
                "province_id" => 13
            ],
            [
                "id" => 476,
                'title' => "اهواز",
                "province_id" => 13
            ],
            [
                "id" => 477,
                'title' => "ایذه",
                "province_id" => 13
            ],
            [
                "id" => 478,
                'title' => "آبادان",
                "province_id" => 13
            ],
            [
                "id" => 479,
                'title' => "آغاجاری",
                "province_id" => 13
            ],
            [
                "id" => 480,
                'title' => "باغ ملک",
                "province_id" => 13
            ],
            [
                "id" => 481,
                'title' => "بستان",
                "province_id" => 13
            ],
            [
                "id" => 482,
                'title' => "بندرامام خمینی",
                "province_id" => 13
            ],
            [
                "id" => 483,
                'title' => "بندرماهشهر",
                "province_id" => 13
            ],
            [
                "id" => 484,
                'title' => "بهبهان",
                "province_id" => 13
            ],
            [
                "id" => 485,
                'title' => "ترکالکی",
                "province_id" => 13
            ],
            [
                "id" => 486,
                'title' => "جایزان",
                "province_id" => 13
            ],
            [
                "id" => 487,
                'title' => "چمران",
                "province_id" => 13
            ],
            [
                "id" => 488,
                'title' => "چویبده",
                "province_id" => 13
            ],
            [
                "id" => 489,
                'title' => "حر",
                "province_id" => 13
            ],
            [
                "id" => 490,
                'title' => "حسینیه",
                "province_id" => 13
            ],
            [
                "id" => 491,
                'title' => "حمزه",
                "province_id" => 13
            ],
            [
                "id" => 492,
                'title' => "حمیدیه",
                "province_id" => 13
            ],
            [
                "id" => 493,
                'title' => "خرمشهر",
                "province_id" => 13
            ],
            [
                "id" => 494,
                'title' => "دارخوین",
                "province_id" => 13
            ],
            [
                "id" => 495,
                'title' => "دزآب",
                "province_id" => 13
            ],
            [
                "id" => 496,
                'title' => "دزفول",
                "province_id" => 13
            ],
            [
                "id" => 497,
                'title' => "دهدز",
                "province_id" => 13
            ],
            [
                "id" => 498,
                'title' => "رامشیر",
                "province_id" => 13
            ],
            [
                "id" => 499,
                'title' => "رامهرمز",
                "province_id" => 13
            ],
            [
                "id" => 500,
                'title' => "رفیع",
                "province_id" => 13
            ],
            [
                "id" => 501,
                'title' => "زهره",
                "province_id" => 13
            ],
            [
                "id" => 502,
                'title' => "سالند",
                "province_id" => 13
            ],
            [
                "id" => 503,
                'title' => "سردشت",
                "province_id" => 13
            ],
            [
                "id" => 504,
                'title' => "سوسنگرد",
                "province_id" => 13
            ],
            [
                "id" => 505,
                'title' => "شادگان",
                "province_id" => 13
            ],
            [
                "id" => 506,
                'title' => "شاوور",
                "province_id" => 13
            ],
            [
                "id" => 507,
                'title' => "شرافت",
                "province_id" => 13
            ],
            [
                "id" => 508,
                'title' => "شوش",
                "province_id" => 13
            ],
            [
                "id" => 509,
                'title' => "شوشتر",
                "province_id" => 13
            ],
            [
                "id" => 510,
                'title' => "شیبان",
                "province_id" => 13
            ],
            [
                "id" => 511,
                'title' => "صالح شهر",
                "province_id" => 13
            ],
            [
                "id" => 512,
                'title' => "صفی آباد",
                "province_id" => 13
            ],
            [
                "id" => 513,
                'title' => "صیدون",
                "province_id" => 13
            ],
            [
                "id" => 514,
                'title' => "قلعه تل",
                "province_id" => 13
            ],
            [
                "id" => 515,
                'title' => "قلعه خواجه",
                "province_id" => 13
            ],
            [
                "id" => 516,
                'title' => "گتوند",
                "province_id" => 13
            ],
            [
                "id" => 517,
                'title' => "لالی",
                "province_id" => 13
            ],
            [
                "id" => 518,
                'title' => "مسجدسلیمان",
                "province_id" => 13
            ],
            [
                "id" => 520,
                'title' => "ملاثانی",
                "province_id" => 13
            ],
            [
                "id" => 521,
                'title' => "میانرود",
                "province_id" => 13
            ],
            [
                "id" => 522,
                'title' => "مینوشهر",
                "province_id" => 13
            ],
            [
                "id" => 523,
                'title' => "هفتگل",
                "province_id" => 13
            ],
            [
                "id" => 524,
                'title' => "هندیجان",
                "province_id" => 13
            ],
            [
                "id" => 525,
                'title' => "هویزه",
                "province_id" => 13
            ],
            [
                "id" => 526,
                'title' => "ویس",
                "province_id" => 13
            ],
            [
                "id" => 527,
                'title' => "ابهر",
                "province_id" => 14
            ],
            [
                "id" => 528,
                'title' => "ارمغان خانه",
                "province_id" => 14
            ],
            [
                "id" => 529,
                'title' => "آب بر",
                "province_id" => 14
            ],
            [
                "id" => 530,
                'title' => "چورزق",
                "province_id" => 14
            ],
            [
                "id" => 531,
                'title' => "حلب",
                "province_id" => 14
            ],
            [
                "id" => 532,
                'title' => "خرمدره",
                "province_id" => 14
            ],
            [
                "id" => 533,
                'title' => "دندی",
                "province_id" => 14
            ],
            [
                "id" => 534,
                'title' => "زرین آباد",
                "province_id" => 14
            ],
            [
                "id" => 535,
                'title' => "زرین رود",
                "province_id" => 14
            ],
            [
                "id" => 536,
                'title' => "زنجان",
                "province_id" => 14
            ],
            [
                "id" => 537,
                'title' => "سجاس",
                "province_id" => 14
            ],
            [
                "id" => 538,
                'title' => "سلطانیه",
                "province_id" => 14
            ],
            [
                "id" => 539,
                'title' => "سهرورد",
                "province_id" => 14
            ],
            [
                "id" => 540,
                'title' => "صائین قلعه",
                "province_id" => 14
            ],
            [
                "id" => 541,
                'title' => "قیدار",
                "province_id" => 14
            ],
            [
                "id" => 542,
                'title' => "گرماب",
                "province_id" => 14
            ],
            [
                "id" => 543,
                'title' => "ماه نشان",
                "province_id" => 14
            ],
            [
                "id" => 544,
                'title' => "هیدج",
                "province_id" => 14
            ],
            [
                "id" => 545,
                'title' => "امیریه",
                "province_id" => 15
            ],
            [
                "id" => 546,
                'title' => "ایوانکی",
                "province_id" => 15
            ],
            [
                "id" => 547,
                'title' => "آرادان",
                "province_id" => 15
            ],
            [
                "id" => 548,
                'title' => "بسطام",
                "province_id" => 15
            ],
            [
                "id" => 549,
                'title' => "بیارجمند",
                "province_id" => 15
            ],
            [
                "id" => 550,
                'title' => "دامغان",
                "province_id" => 15
            ],
            [
                "id" => 551,
                'title' => "درجزین",
                "province_id" => 15
            ],
            [
                "id" => 552,
                'title' => "دیباج",
                "province_id" => 15
            ],
            [
                "id" => 553,
                'title' => "سرخه",
                "province_id" => 15
            ],
            [
                "id" => 554,
                'title' => "سمنان",
                "province_id" => 15
            ],
            [
                "id" => 555,
                'title' => "شاهرود",
                "province_id" => 15
            ],
            [
                "id" => 556,
                'title' => "شهمیرزاد",
                "province_id" => 15
            ],
            [
                "id" => 557,
                'title' => "کلاته خیج",
                "province_id" => 15
            ],
            [
                "id" => 558,
                'title' => "گرمسار",
                "province_id" => 15
            ],
            [
                "id" => 559,
                'title' => "مجن",
                "province_id" => 15
            ],
            [
                "id" => 560,
                'title' => "مهدی شهر",
                "province_id" => 15
            ],
            [
                "id" => 561,
                'title' => "میامی",
                "province_id" => 15
            ],
            [
                "id" => 562,
                'title' => "ادیمی",
                "province_id" => 16
            ],
            [
                "id" => 563,
                'title' => "اسپکه",
                "province_id" => 16
            ],
            [
                "id" => 564,
                'title' => "ایرانشهر",
                "province_id" => 16
            ],
            [
                "id" => 565,
                'title' => "بزمان",
                "province_id" => 16
            ],
            [
                "id" => 566,
                'title' => "بمپور",
                "province_id" => 16
            ],
            [
                "id" => 567,
                'title' => "بنت",
                "province_id" => 16
            ],
            [
                "id" => 568,
                'title' => "بنجار",
                "province_id" => 16
            ],
            [
                "id" => 569,
                'title' => "پیشین",
                "province_id" => 16
            ],
            [
                "id" => 570,
                'title' => "جالق",
                "province_id" => 16
            ],
            [
                "id" => 571,
                'title' => "چابهار",
                "province_id" => 16
            ],
            [
                "id" => 572,
                'title' => "خاش",
                "province_id" => 16
            ],
            [
                "id" => 573,
                'title' => "دوست محمد",
                "province_id" => 16
            ],
            [
                "id" => 574,
                'title' => "راسک",
                "province_id" => 16
            ],
            [
                "id" => 575,
                'title' => "زابل",
                "province_id" => 16
            ],
            [
                "id" => 576,
                'title' => "زابلی",
                "province_id" => 16
            ],
            [
                "id" => 577,
                'title' => "زاهدان",
                "province_id" => 16
            ],
            [
                "id" => 578,
                'title' => "زهک",
                "province_id" => 16
            ],
            [
                "id" => 579,
                'title' => "سراوان",
                "province_id" => 16
            ],
            [
                "id" => 580,
                'title' => "سرباز",
                "province_id" => 16
            ],
            [
                "id" => 581,
                'title' => "سوران",
                "province_id" => 16
            ],
            [
                "id" => 582,
                'title' => "سیرکان",
                "province_id" => 16
            ],
            [
                "id" => 583,
                'title' => "علی اکبر",
                "province_id" => 16
            ],
            [
                "id" => 584,
                'title' => "فنوج",
                "province_id" => 16
            ],
            [
                "id" => 585,
                'title' => "قصرقند",
                "province_id" => 16
            ],
            [
                "id" => 586,
                'title' => "کنارک",
                "province_id" => 16
            ],
            [
                "id" => 587,
                'title' => "گشت",
                "province_id" => 16
            ],
            [
                "id" => 588,
                'title' => "گلمورتی",
                "province_id" => 16
            ],
            [
                "id" => 589,
                'title' => "محمدان",
                "province_id" => 16
            ],
            [
                "id" => 590,
                'title' => "محمدآباد",
                "province_id" => 16
            ],
            [
                "id" => 591,
                'title' => "محمدی",
                "province_id" => 16
            ],
            [
                "id" => 592,
                'title' => "میرجاوه",
                "province_id" => 16
            ],
            [
                "id" => 593,
                'title' => "نصرت آباد",
                "province_id" => 16
            ],
            [
                "id" => 594,
                'title' => "نگور",
                "province_id" => 16
            ],
            [
                "id" => 595,
                'title' => "نوک آباد",
                "province_id" => 16
            ],
            [
                "id" => 596,
                'title' => "نیک شهر",
                "province_id" => 16
            ],
            [
                "id" => 597,
                'title' => "هیدوچ",
                "province_id" => 16
            ],
            [
                "id" => 598,
                'title' => "اردکان",
                "province_id" => 17
            ],
            [
                "id" => 599,
                'title' => "ارسنجان",
                "province_id" => 17
            ],
            [
                "id" => 600,
                'title' => "استهبان",
                "province_id" => 17
            ],
            [
                "id" => 601,
                'title' => "اشکنان",
                "province_id" => 17
            ],
            [
                "id" => 602,
                'title' => "افزر",
                "province_id" => 17
            ],
            [
                "id" => 603,
                'title' => "اقلید",
                "province_id" => 17
            ],
            [
                "id" => 604,
                'title' => "امام شهر",
                "province_id" => 17
            ],
            [
                "id" => 605,
                'title' => "اهل",
                "province_id" => 17
            ],
            [
                "id" => 606,
                'title' => "اوز",
                "province_id" => 17
            ],
            [
                "id" => 607,
                'title' => "ایج",
                "province_id" => 17
            ],
            [
                "id" => 608,
                'title' => "ایزدخواست",
                "province_id" => 17
            ],
            [
                "id" => 609,
                'title' => "آباده",
                "province_id" => 17
            ],
            [
                "id" => 610,
                'title' => "آباده طشک",
                "province_id" => 17
            ],
            [
                "id" => 611,
                'title' => "باب انار",
                "province_id" => 17
            ],
            [
                "id" => 612,
                'title' => "بالاده",
                "province_id" => 17
            ],
            [
                "id" => 613,
                'title' => "بنارویه",
                "province_id" => 17
            ],
            [
                "id" => 614,
                'title' => "بهمن",
                "province_id" => 17
            ],
            [
                "id" => 615,
                'title' => "بوانات",
                "province_id" => 17
            ],
            [
                "id" => 616,
                'title' => "بیرم",
                "province_id" => 17
            ],
            [
                "id" => 617,
                'title' => "بیضا",
                "province_id" => 17
            ],
            [
                "id" => 618,
                'title' => "جنت شهر",
                "province_id" => 17
            ],
            [
                "id" => 619,
                'title' => "جهرم",
                "province_id" => 17
            ],
            [
                "id" => 620,
                'title' => "جویم",
                "province_id" => 17
            ],
            [
                "id" => 621,
                'title' => "زرین دشت",
                "province_id" => 17
            ],
            [
                "id" => 622,
                'title' => "حسن آباد",
                "province_id" => 17
            ],
            [
                "id" => 623,
                'title' => "خان زنیان",
                "province_id" => 17
            ],
            [
                "id" => 624,
                'title' => "خاوران",
                "province_id" => 17
            ],
            [
                "id" => 625,
                'title' => "خرامه",
                "province_id" => 17
            ],
            [
                "id" => 626,
                'title' => "خشت",
                "province_id" => 17
            ],
            [
                "id" => 627,
                'title' => "خنج",
                "province_id" => 17
            ],
            [
                "id" => 628,
                'title' => "خور",
                "province_id" => 17
            ],
            [
                "id" => 629,
                'title' => "داراب",
                "province_id" => 17
            ],
            [
                "id" => 630,
                'title' => "داریان",
                "province_id" => 17
            ],
            [
                "id" => 631,
                'title' => "دبیران",
                "province_id" => 17
            ],
            [
                "id" => 632,
                'title' => "دژکرد",
                "province_id" => 17
            ],
            [
                "id" => 633,
                'title' => "دهرم",
                "province_id" => 17
            ],
            [
                "id" => 634,
                'title' => "دوبرجی",
                "province_id" => 17
            ],
            [
                "id" => 635,
                'title' => "رامجرد",
                "province_id" => 17
            ],
            [
                "id" => 636,
                'title' => "رونیز",
                "province_id" => 17
            ],
            [
                "id" => 637,
                'title' => "زاهدشهر",
                "province_id" => 17
            ],
            [
                "id" => 638,
                'title' => "زرقان",
                "province_id" => 17
            ],
            [
                "id" => 639,
                'title' => "سده",
                "province_id" => 17
            ],
            [
                "id" => 640,
                'title' => "سروستان",
                "province_id" => 17
            ],
            [
                "id" => 641,
                'title' => "سعادت شهر",
                "province_id" => 17
            ],
            [
                "id" => 642,
                'title' => "سورمق",
                "province_id" => 17
            ],
            [
                "id" => 643,
                'title' => "سیدان",
                "province_id" => 17
            ],
            [
                "id" => 644,
                'title' => "ششده",
                "province_id" => 17
            ],
            [
                "id" => 645,
                'title' => "شهرپیر",
                "province_id" => 17
            ],
            [
                "id" => 646,
                'title' => "شهرصدرا",
                "province_id" => 17
            ],
            [
                "id" => 647,
                'title' => "شیراز",
                "province_id" => 17
            ],
            [
                "id" => 648,
                'title' => "صغاد",
                "province_id" => 17
            ],
            [
                "id" => 649,
                'title' => "صفاشهر",
                "province_id" => 17
            ],
            [
                "id" => 650,
                'title' => "علامرودشت",
                "province_id" => 17
            ],
            [
                "id" => 651,
                'title' => "فدامی",
                "province_id" => 17
            ],
            [
                "id" => 652,
                'title' => "فراشبند",
                "province_id" => 17
            ],
            [
                "id" => 653,
                'title' => "فسا",
                "province_id" => 17
            ],
            [
                "id" => 654,
                'title' => "فیروزآباد",
                "province_id" => 17
            ],
            [
                "id" => 655,
                'title' => "قائمیه",
                "province_id" => 17
            ],
            [
                "id" => 656,
                'title' => "قادرآباد",
                "province_id" => 17
            ],
            [
                "id" => 657,
                'title' => "قطب آباد",
                "province_id" => 17
            ],
            [
                "id" => 658,
                'title' => "قطرویه",
                "province_id" => 17
            ],
            [
                "id" => 659,
                'title' => "قیر",
                "province_id" => 17
            ],
            [
                "id" => 660,
                'title' => "کارزین (فتح آباد)",
                "province_id" => 17
            ],
            [
                "id" => 661,
                'title' => "کازرون",
                "province_id" => 17
            ],
            [
                "id" => 662,
                'title' => "کامفیروز",
                "province_id" => 17
            ],
            [
                "id" => 663,
                'title' => "کره ای",
                "province_id" => 17
            ],
            [
                "id" => 664,
                'title' => "کنارتخته",
                "province_id" => 17
            ],
            [
                "id" => 665,
                'title' => "کوار",
                "province_id" => 17
            ],
            [
                "id" => 666,
                'title' => "گراش",
                "province_id" => 17
            ],
            [
                "id" => 667,
                'title' => "گله دار",
                "province_id" => 17
            ],
            [
                "id" => 668,
                'title' => "لار",
                "province_id" => 17
            ],
            [
                "id" => 669,
                'title' => "لامرد",
                "province_id" => 17
            ],
            [
                "id" => 670,
                'title' => "لپویی",
                "province_id" => 17
            ],
            [
                "id" => 671,
                'title' => "لطیفی",
                "province_id" => 17
            ],
            [
                "id" => 672,
                'title' => "مبارک آباددیز",
                "province_id" => 17
            ],
            [
                "id" => 673,
                'title' => "مرودشت",
                "province_id" => 17
            ],
            [
                "id" => 674,
                'title' => "مشکان",
                "province_id" => 17
            ],
            [
                "id" => 675,
                'title' => "مصیری",
                "province_id" => 17
            ],
            [
                "id" => 676,
                'title' => "مهر",
                "province_id" => 17
            ],
            [
                "id" => 677,
                'title' => "میمند",
                "province_id" => 17
            ],
            [
                "id" => 678,
                'title' => "نوبندگان",
                "province_id" => 17
            ],
            [
                "id" => 679,
                'title' => "نوجین",
                "province_id" => 17
            ],
            [
                "id" => 680,
                'title' => "نودان",
                "province_id" => 17
            ],
            [
                "id" => 681,
                'title' => "نورآباد",
                "province_id" => 17
            ],
            [
                "id" => 682,
                'title' => "نی ریز",
                "province_id" => 17
            ],
            [
                "id" => 683,
                'title' => "وراوی",
                "province_id" => 17
            ],
            [
                "id" => 684,
                'title' => "ارداق",
                "province_id" => 18
            ],
            [
                "id" => 685,
                'title' => "اسفرورین",
                "province_id" => 18
            ],
            [
                "id" => 686,
                'title' => "اقبالیه",
                "province_id" => 18
            ],
            [
                "id" => 687,
                'title' => "الوند",
                "province_id" => 18
            ],
            [
                "id" => 688,
                'title' => "آبگرم",
                "province_id" => 18
            ],
            [
                "id" => 689,
                'title' => "آبیک",
                "province_id" => 18
            ],
            [
                "id" => 690,
                'title' => "آوج",
                "province_id" => 18
            ],
            [
                "id" => 691,
                'title' => "بوئین زهرا",
                "province_id" => 18
            ],
            [
                "id" => 692,
                'title' => "بیدستان",
                "province_id" => 18
            ],
            [
                "id" => 693,
                'title' => "تاکستان",
                "province_id" => 18
            ],
            [
                "id" => 694,
                'title' => "خاکعلی",
                "province_id" => 18
            ],
            [
                "id" => 695,
                'title' => "خرمدشت",
                "province_id" => 18
            ],
            [
                "id" => 696,
                'title' => "دانسفهان",
                "province_id" => 18
            ],
            [
                "id" => 697,
                'title' => "رازمیان",
                "province_id" => 18
            ],
            [
                "id" => 698,
                'title' => "سگزآباد",
                "province_id" => 18
            ],
            [
                "id" => 699,
                'title' => "سیردان",
                "province_id" => 18
            ],
            [
                "id" => 700,
                'title' => "شال",
                "province_id" => 18
            ],
            [
                "id" => 701,
                'title' => "شریفیه",
                "province_id" => 18
            ],
            [
                "id" => 702,
                'title' => "ضیاآباد",
                "province_id" => 18
            ],
            [
                "id" => 703,
                'title' => "قزوین",
                "province_id" => 18
            ],
            [
                "id" => 704,
                'title' => "کوهین",
                "province_id" => 18
            ],
            [
                "id" => 705,
                'title' => "محمدیه",
                "province_id" => 18
            ],
            [
                "id" => 706,
                'title' => "محمودآباد نمونه",
                "province_id" => 18
            ],
            [
                "id" => 707,
                'title' => "معلم کلایه",
                "province_id" => 18
            ],
            [
                "id" => 708,
                'title' => "نرجه",
                "province_id" => 18
            ],
            [
                "id" => 709,
                'title' => "جعفریه",
                "province_id" => 19
            ],
            [
                "id" => 710,
                'title' => "دستجرد",
                "province_id" => 19
            ],
            [
                "id" => 711,
                'title' => "سلفچگان",
                "province_id" => 19
            ],
            [
                "id" => 712,
                'title' => "قم",
                "province_id" => 19
            ],
            [
                "id" => 713,
                'title' => "قنوات",
                "province_id" => 19
            ],
            [
                "id" => 714,
                'title' => "کهک",
                "province_id" => 19
            ],
            [
                "id" => 715,
                'title' => "آرمرده",
                "province_id" => 20
            ],
            [
                "id" => 716,
                'title' => "بابارشانی",
                "province_id" => 20
            ],
            [
                "id" => 717,
                'title' => "بانه",
                "province_id" => 20
            ],
            [
                "id" => 718,
                'title' => "بلبان آباد",
                "province_id" => 20
            ],
            [
                "id" => 719,
                'title' => "بوئین سفلی",
                "province_id" => 20
            ],
            [
                "id" => 720,
                'title' => "بیجار",
                "province_id" => 20
            ],
            [
                "id" => 721,
                'title' => "چناره",
                "province_id" => 20
            ],
            [
                "id" => 722,
                'title' => "دزج",
                "province_id" => 20
            ],
            [
                "id" => 723,
                'title' => "دلبران",
                "province_id" => 20
            ],
            [
                "id" => 724,
                'title' => "دهگلان",
                "province_id" => 20
            ],
            [
                "id" => 725,
                'title' => "دیواندره",
                "province_id" => 20
            ],
            [
                "id" => 726,
                'title' => "زرینه",
                "province_id" => 20
            ],
            [
                "id" => 727,
                'title' => "سروآباد",
                "province_id" => 20
            ],
            [
                "id" => 728,
                'title' => "سریش آباد",
                "province_id" => 20
            ],
            [
                "id" => 729,
                'title' => "سقز",
                "province_id" => 20
            ],
            [
                "id" => 730,
                'title' => "سنندج",
                "province_id" => 20
            ],
            [
                "id" => 731,
                'title' => "شویشه",
                "province_id" => 20
            ],
            [
                "id" => 732,
                'title' => "صاحب",
                "province_id" => 20
            ],
            [
                "id" => 733,
                'title' => "قروه",
                "province_id" => 20
            ],
            [
                "id" => 734,
                'title' => "کامیاران",
                "province_id" => 20
            ],
            [
                "id" => 735,
                'title' => "کانی دینار",
                "province_id" => 20
            ],
            [
                "id" => 736,
                'title' => "کانی سور",
                "province_id" => 20
            ],
            [
                "id" => 737,
                'title' => "مریوان",
                "province_id" => 20
            ],
            [
                "id" => 738,
                'title' => "موچش",
                "province_id" => 20
            ],
            [
                "id" => 739,
                'title' => "یاسوکند",
                "province_id" => 20
            ],
            [
                "id" => 740,
                'title' => "اختیارآباد",
                "province_id" => 21
            ],
            [
                "id" => 741,
                'title' => "ارزوئیه",
                "province_id" => 21
            ],
            [
                "id" => 742,
                'title' => "امین شهر",
                "province_id" => 21
            ],
            [
                "id" => 743,
                'title' => "انار",
                "province_id" => 21
            ],
            [
                "id" => 744,
                'title' => "اندوهجرد",
                "province_id" => 21
            ],
            [
                "id" => 745,
                'title' => "باغین",
                "province_id" => 21
            ],
            [
                "id" => 746,
                'title' => "بافت",
                "province_id" => 21
            ],
            [
                "id" => 747,
                'title' => "بردسیر",
                "province_id" => 21
            ],
            [
                "id" => 748,
                'title' => "بروات",
                "province_id" => 21
            ],
            [
                "id" => 749,
                'title' => "بزنجان",
                "province_id" => 21
            ],
            [
                "id" => 750,
                'title' => "بم",
                "province_id" => 21
            ],
            [
                "id" => 751,
                'title' => "بهرمان",
                "province_id" => 21
            ],
            [
                "id" => 752,
                'title' => "پاریز",
                "province_id" => 21
            ],
            [
                "id" => 753,
                'title' => "جبالبارز",
                "province_id" => 21
            ],
            [
                "id" => 754,
                'title' => "جوپار",
                "province_id" => 21
            ],
            [
                "id" => 755,
                'title' => "جوزم",
                "province_id" => 21
            ],
            [
                "id" => 756,
                'title' => "جیرفت",
                "province_id" => 21
            ],
            [
                "id" => 757,
                'title' => "چترود",
                "province_id" => 21
            ],
            [
                "id" => 758,
                'title' => "خاتون آباد",
                "province_id" => 21
            ],
            [
                "id" => 759,
                'title' => "خانوک",
                "province_id" => 21
            ],
            [
                "id" => 760,
                'title' => "خورسند",
                "province_id" => 21
            ],
            [
                "id" => 761,
                'title' => "درب بهشت",
                "province_id" => 21
            ],
            [
                "id" => 762,
                'title' => "دهج",
                "province_id" => 21
            ],
            [
                "id" => 763,
                'title' => "رابر",
                "province_id" => 21
            ],
            [
                "id" => 764,
                'title' => "راور",
                "province_id" => 21
            ],
            [
                "id" => 765,
                'title' => "راین",
                "province_id" => 21
            ],
            [
                "id" => 766,
                'title' => "رفسنجان",
                "province_id" => 21
            ],
            [
                "id" => 767,
                'title' => "رودبار",
                "province_id" => 21
            ],
            [
                "id" => 768,
                'title' => "ریحان شهر",
                "province_id" => 21
            ],
            [
                "id" => 769,
                'title' => "زرند",
                "province_id" => 21
            ],
            [
                "id" => 770,
                'title' => "زنگی آباد",
                "province_id" => 21
            ],
            [
                "id" => 771,
                'title' => "زیدآباد",
                "province_id" => 21
            ],
            [
                "id" => 772,
                'title' => "سیرجان",
                "province_id" => 21
            ],
            [
                "id" => 773,
                'title' => "شهداد",
                "province_id" => 21
            ],
            [
                "id" => 774,
                'title' => "شهربابک",
                "province_id" => 21
            ],
            [
                "id" => 775,
                'title' => "صفائیه",
                "province_id" => 21
            ],
            [
                "id" => 776,
                'title' => "عنبرآباد",
                "province_id" => 21
            ],
            [
                "id" => 777,
                'title' => "فاریاب",
                "province_id" => 21
            ],
            [
                "id" => 778,
                'title' => "فهرج",
                "province_id" => 21
            ],
            [
                "id" => 779,
                'title' => "قلعه گنج",
                "province_id" => 21
            ],
            [
                "id" => 780,
                'title' => "کاظم آباد",
                "province_id" => 21
            ],
            [
                "id" => 781,
                'title' => "کرمان",
                "province_id" => 21
            ],
            [
                "id" => 782,
                'title' => "کشکوئیه",
                "province_id" => 21
            ],
            [
                "id" => 783,
                'title' => "کهنوج",
                "province_id" => 21
            ],
            [
                "id" => 784,
                'title' => "کوهبنان",
                "province_id" => 21
            ],
            [
                "id" => 785,
                'title' => "کیانشهر",
                "province_id" => 21
            ],
            [
                "id" => 786,
                'title' => "گلباف",
                "province_id" => 21
            ],
            [
                "id" => 787,
                'title' => "گلزار",
                "province_id" => 21
            ],
            [
                "id" => 788,
                'title' => "لاله زار",
                "province_id" => 21
            ],
            [
                "id" => 789,
                'title' => "ماهان",
                "province_id" => 21
            ],
            [
                "id" => 790,
                'title' => "محمدآباد",
                "province_id" => 21
            ],
            [
                "id" => 791,
                'title' => "محی آباد",
                "province_id" => 21
            ],
            [
                "id" => 792,
                'title' => "مردهک",
                "province_id" => 21
            ],
            [
                "id" => 793,
                'title' => "مس سرچشمه",
                "province_id" => 21
            ],
            [
                "id" => 794,
                'title' => "منوجان",
                "province_id" => 21
            ],
            [
                "id" => 795,
                'title' => "نجف شهر",
                "province_id" => 21
            ],
            [
                "id" => 796,
                'title' => "نرماشیر",
                "province_id" => 21
            ],
            [
                "id" => 797,
                'title' => "نظام شهر",
                "province_id" => 21
            ],
            [
                "id" => 798,
                'title' => "نگار",
                "province_id" => 21
            ],
            [
                "id" => 799,
                'title' => "نودژ",
                "province_id" => 21
            ],
            [
                "id" => 800,
                'title' => "هجدک",
                "province_id" => 21
            ],
            [
                "id" => 801,
                'title' => "یزدان شهر",
                "province_id" => 21
            ],
            [
                "id" => 802,
                'title' => "ازگله",
                "province_id" => 22
            ],
            [
                "id" => 803,
                'title' => "اسلام آباد غرب",
                "province_id" => 22
            ],
            [
                "id" => 804,
                'title' => "باینگان",
                "province_id" => 22
            ],
            [
                "id" => 805,
                'title' => "بیستون",
                "province_id" => 22
            ],
            [
                "id" => 806,
                'title' => "پاوه",
                "province_id" => 22
            ],
            [
                "id" => 807,
                'title' => "تازه آباد",
                "province_id" => 22
            ],
            [
                "id" => 808,
                'title' => "جوان رود",
                "province_id" => 22
            ],
            [
                "id" => 809,
                'title' => "حمیل",
                "province_id" => 22
            ],
            [
                "id" => 810,
                'title' => "ماهیدشت",
                "province_id" => 22
            ],
            [
                "id" => 811,
                'title' => "روانسر",
                "province_id" => 22
            ],
            [
                "id" => 812,
                'title' => "سرپل ذهاب",
                "province_id" => 22
            ],
            [
                "id" => 813,
                'title' => "سرمست",
                "province_id" => 22
            ],
            [
                "id" => 814,
                'title' => "سطر",
                "province_id" => 22
            ],
            [
                "id" => 815,
                'title' => "سنقر",
                "province_id" => 22
            ],
            [
                "id" => 816,
                'title' => "سومار",
                "province_id" => 22
            ],
            [
                "id" => 817,
                'title' => "شاهو",
                "province_id" => 22
            ],
            [
                "id" => 818,
                'title' => "صحنه",
                "province_id" => 22
            ],
            [
                "id" => 819,
                'title' => "قصرشیرین",
                "province_id" => 22
            ],
            [
                "id" => 820,
                'title' => "کرمانشاه",
                "province_id" => 22
            ],
            [
                "id" => 821,
                'title' => "کرندغرب",
                "province_id" => 22
            ],
            [
                "id" => 822,
                'title' => "کنگاور",
                "province_id" => 22
            ],
            [
                "id" => 823,
                'title' => "کوزران",
                "province_id" => 22
            ],
            [
                "id" => 824,
                'title' => "گهواره",
                "province_id" => 22
            ],
            [
                "id" => 825,
                'title' => "گیلانغرب",
                "province_id" => 22
            ],
            [
                "id" => 826,
                'title' => "میان راهان",
                "province_id" => 22
            ],
            [
                "id" => 827,
                'title' => "نودشه",
                "province_id" => 22
            ],
            [
                "id" => 828,
                'title' => "نوسود",
                "province_id" => 22
            ],
            [
                "id" => 829,
                'title' => "هرسین",
                "province_id" => 22
            ],
            [
                "id" => 830,
                'title' => "هلشی",
                "province_id" => 22
            ],
            [
                "id" => 831,
                'title' => "باشت",
                "province_id" => 23
            ],
            [
                "id" => 832,
                'title' => "پاتاوه",
                "province_id" => 23
            ],
            [
                "id" => 833,
                'title' => "چرام",
                "province_id" => 23
            ],
            [
                "id" => 834,
                'title' => "چیتاب",
                "province_id" => 23
            ],
            [
                "id" => 835,
                'title' => "دهدشت",
                "province_id" => 23
            ],
            [
                "id" => 836,
                'title' => "دوگنبدان",
                "province_id" => 23
            ],
            [
                "id" => 837,
                'title' => "دیشموک",
                "province_id" => 23
            ],
            [
                "id" => 838,
                'title' => "سوق",
                "province_id" => 23
            ],
            [
                "id" => 839,
                'title' => "سی سخت",
                "province_id" => 23
            ],
            [
                "id" => 840,
                'title' => "قلعه رئیسی",
                "province_id" => 23
            ],
            [
                "id" => 841,
                'title' => "گراب سفلی",
                "province_id" => 23
            ],
            [
                "id" => 842,
                'title' => "لنده",
                "province_id" => 23
            ],
            [
                "id" => 843,
                'title' => "لیکک",
                "province_id" => 23
            ],
            [
                "id" => 844,
                'title' => "مادوان",
                "province_id" => 23
            ],
            [
                "id" => 845,
                'title' => "مارگون",
                "province_id" => 23
            ],
            [
                "id" => 846,
                'title' => "یاسوج",
                "province_id" => 23
            ],
            [
                "id" => 847,
                'title' => "انبارآلوم",
                "province_id" => 24
            ],
            [
                "id" => 848,
                'title' => "اینچه برون",
                "province_id" => 24
            ],
            [
                "id" => 849,
                'title' => "آزادشهر",
                "province_id" => 24
            ],
            [
                "id" => 850,
                'title' => "آق قلا",
                "province_id" => 24
            ],
            [
                "id" => 851,
                'title' => "بندرترکمن",
                "province_id" => 24
            ],
            [
                "id" => 852,
                'title' => "بندرگز",
                "province_id" => 24
            ],
            [
                "id" => 853,
                'title' => "جلین",
                "province_id" => 24
            ],
            [
                "id" => 854,
                'title' => "خان ببین",
                "province_id" => 24
            ],
            [
                "id" => 855,
                'title' => "دلند",
                "province_id" => 24
            ],
            [
                "id" => 856,
                'title' => "رامیان",
                "province_id" => 24
            ],
            [
                "id" => 857,
                'title' => "سرخنکلاته",
                "province_id" => 24
            ],
            [
                "id" => 858,
                'title' => "سیمین شهر",
                "province_id" => 24
            ],
            [
                "id" => 859,
                'title' => "علی آباد کتول",
                "province_id" => 24
            ],
            [
                "id" => 860,
                'title' => "فاضل آباد",
                "province_id" => 24
            ],
            [
                "id" => 861,
                'title' => "کردکوی",
                "province_id" => 24
            ],
            [
                "id" => 862,
                'title' => "کلاله",
                "province_id" => 24
            ],
            [
                "id" => 863,
                'title' => "گالیکش",
                "province_id" => 24
            ],
            [
                "id" => 864,
                'title' => "گرگان",
                "province_id" => 24
            ],
            [
                "id" => 865,
                'title' => "گمیش تپه",
                "province_id" => 24
            ],
            [
                "id" => 866,
                'title' => "گنبدکاووس",
                "province_id" => 24
            ],
            [
                "id" => 867,
                'title' => "مراوه",
                "province_id" => 24
            ],
            [
                "id" => 868,
                'title' => "مینودشت",
                "province_id" => 24
            ],
            [
                "id" => 869,
                'title' => "نگین شهر",
                "province_id" => 24
            ],
            [
                "id" => 870,
                'title' => "نوده خاندوز",
                "province_id" => 24
            ],
            [
                "id" => 871,
                'title' => "نوکنده",
                "province_id" => 24
            ],
            [
                "id" => 872,
                'title' => "ازنا",
                "province_id" => 25
            ],
            [
                "id" => 873,
                'title' => "اشترینان",
                "province_id" => 25
            ],
            [
                "id" => 874,
                'title' => "الشتر",
                "province_id" => 25
            ],
            [
                "id" => 875,
                'title' => "الیگودرز",
                "province_id" => 25
            ],
            [
                "id" => 876,
                'title' => "بروجرد",
                "province_id" => 25
            ],
            [
                "id" => 877,
                'title' => "پلدختر",
                "province_id" => 25
            ],
            [
                "id" => 878,
                'title' => "چالانچولان",
                "province_id" => 25
            ],
            [
                "id" => 879,
                'title' => "چغلوندی",
                "province_id" => 25
            ],
            [
                "id" => 880,
                'title' => "چقابل",
                "province_id" => 25
            ],
            [
                "id" => 881,
                'title' => "خرم آباد",
                "province_id" => 25
            ],
            [
                "id" => 882,
                'title' => "درب گنبد",
                "province_id" => 25
            ],
            [
                "id" => 883,
                'title' => "دورود",
                "province_id" => 25
            ],
            [
                "id" => 884,
                'title' => "زاغه",
                "province_id" => 25
            ],
            [
                "id" => 885,
                'title' => "سپیددشت",
                "province_id" => 25
            ],
            [
                "id" => 886,
                'title' => "سراب دوره",
                "province_id" => 25
            ],
            [
                "id" => 887,
                'title' => "فیروزآباد",
                "province_id" => 25
            ],
            [
                "id" => 888,
                'title' => "کونانی",
                "province_id" => 25
            ],
            [
                "id" => 889,
                'title' => "کوهدشت",
                "province_id" => 25
            ],
            [
                "id" => 890,
                'title' => "گراب",
                "province_id" => 25
            ],
            [
                "id" => 891,
                'title' => "معمولان",
                "province_id" => 25
            ],
            [
                "id" => 892,
                'title' => "مومن آباد",
                "province_id" => 25
            ],
            [
                "id" => 893,
                'title' => "نورآباد",
                "province_id" => 25
            ],
            [
                "id" => 894,
                'title' => "ویسیان",
                "province_id" => 25
            ],
            [
                "id" => 895,
                'title' => "احمدسرگوراب",
                "province_id" => 26
            ],
            [
                "id" => 896,
                'title' => "اسالم",
                "province_id" => 26
            ],
            [
                "id" => 897,
                'title' => "اطاقور",
                "province_id" => 26
            ],
            [
                "id" => 898,
                'title' => "املش",
                "province_id" => 26
            ],
            [
                "id" => 899,
                'title' => "آستارا",
                "province_id" => 26
            ],
            [
                "id" => 900,
                'title' => "آستانه اشرفیه",
                "province_id" => 26
            ],
            [
                "id" => 901,
                'title' => "بازار جمعه",
                "province_id" => 26
            ],
            [
                "id" => 902,
                'title' => "بره سر",
                "province_id" => 26
            ],
            [
                "id" => 903,
                'title' => "بندرانزلی",
                "province_id" => 26
            ],
            [
                "id" => 906,
                'title' => "پره سر",
                "province_id" => 26
            ],
            [
                "id" => 907,
                'title' => "تالش",
                "province_id" => 26
            ],
            [
                "id" => 908,
                'title' => "توتکابن",
                "province_id" => 26
            ],
            [
                "id" => 909,
                'title' => "جیرنده",
                "province_id" => 26
            ],
            [
                "id" => 910,
                'title' => "چابکسر",
                "province_id" => 26
            ],
            [
                "id" => 911,
                'title' => "چاف و چمخاله",
                "province_id" => 26
            ],
            [
                "id" => 912,
                'title' => "چوبر",
                "province_id" => 26
            ],
            [
                "id" => 913,
                'title' => "حویق",
                "province_id" => 26
            ],
            [
                "id" => 914,
                'title' => "خشکبیجار",
                "province_id" => 26
            ],
            [
                "id" => 915,
                'title' => "خمام",
                "province_id" => 26
            ],
            [
                "id" => 916,
                'title' => "دیلمان",
                "province_id" => 26
            ],
            [
                "id" => 917,
                'title' => "رانکوه",
                "province_id" => 26
            ],
            [
                "id" => 918,
                'title' => "رحیم آباد",
                "province_id" => 26
            ],
            [
                "id" => 919,
                'title' => "رستم آباد",
                "province_id" => 26
            ],
            [
                "id" => 920,
                'title' => "رشت",
                "province_id" => 26
            ],
            [
                "id" => 921,
                'title' => "رضوانشهر",
                "province_id" => 26
            ],
            [
                "id" => 922,
                'title' => "رودبار",
                "province_id" => 26
            ],
            [
                "id" => 923,
                'title' => "رودبنه",
                "province_id" => 26
            ],
            [
                "id" => 924,
                'title' => "رودسر",
                "province_id" => 26
            ],
            [
                "id" => 925,
                'title' => "سنگر",
                "province_id" => 26
            ],
            [
                "id" => 926,
                'title' => "سیاهکل",
                "province_id" => 26
            ],
            [
                "id" => 927,
                'title' => "شفت",
                "province_id" => 26
            ],
            [
                "id" => 928,
                'title' => "شلمان",
                "province_id" => 26
            ],
            [
                "id" => 929,
                'title' => "صومعه سرا",
                "province_id" => 26
            ],
            [
                "id" => 930,
                'title' => "فومن",
                "province_id" => 26
            ],
            [
                "id" => 931,
                'title' => "کلاچای",
                "province_id" => 26
            ],
            [
                "id" => 932,
                'title' => "کوچصفهان",
                "province_id" => 26
            ],
            [
                "id" => 933,
                'title' => "کومله",
                "province_id" => 26
            ],
            [
                "id" => 934,
                'title' => "کیاشهر",
                "province_id" => 26
            ],
            [
                "id" => 935,
                'title' => "گوراب زرمیخ",
                "province_id" => 26
            ],
            [
                "id" => 936,
                'title' => "لاهیجان",
                "province_id" => 26
            ],
            [
                "id" => 937,
                'title' => "لشت نشا",
                "province_id" => 26
            ],
            [
                "id" => 938,
                'title' => "لنگرود",
                "province_id" => 26
            ],
            [
                "id" => 939,
                'title' => "لوشان",
                "province_id" => 26
            ],
            [
                "id" => 940,
                'title' => "لولمان",
                "province_id" => 26
            ],
            [
                "id" => 941,
                'title' => "لوندویل",
                "province_id" => 26
            ],
            [
                "id" => 942,
                'title' => "لیسار",
                "province_id" => 26
            ],
            [
                "id" => 943,
                'title' => "ماسال",
                "province_id" => 26
            ],
            [
                "id" => 944,
                'title' => "ماسوله",
                "province_id" => 26
            ],
            [
                "id" => 945,
                'title' => "مرجقل",
                "province_id" => 26
            ],
            [
                "id" => 946,
                'title' => "منجیل",
                "province_id" => 26
            ],
            [
                "id" => 947,
                'title' => "واجارگاه",
                "province_id" => 26
            ],
            [
                "id" => 948,
                'title' => "امیرکلا",
                "province_id" => 27
            ],
            [
                "id" => 949,
                'title' => "ایزدشهر",
                "province_id" => 27
            ],
            [
                "id" => 950,
                'title' => "آلاشت",
                "province_id" => 27
            ],
            [
                "id" => 951,
                'title' => "آمل",
                "province_id" => 27
            ],
            [
                "id" => 952,
                'title' => "بابل",
                "province_id" => 27
            ],
            [
                "id" => 953,
                'title' => "بابلسر",
                "province_id" => 27
            ],
            [
                "id" => 954,
                'title' => "بلده",
                "province_id" => 27
            ],
            [
                "id" => 955,
                'title' => "بهشهر",
                "province_id" => 27
            ],
            [
                "id" => 956,
                'title' => "بهنمیر",
                "province_id" => 27
            ],
            [
                "id" => 957,
                'title' => "پل سفید",
                "province_id" => 27
            ],
            [
                "id" => 958,
                'title' => "تنکابن",
                "province_id" => 27
            ],
            [
                "id" => 959,
                'title' => "جویبار",
                "province_id" => 27
            ],
            [
                "id" => 960,
                'title' => "چالوس",
                "province_id" => 27
            ],
            [
                "id" => 961,
                'title' => "چمستان",
                "province_id" => 27
            ],
            [
                "id" => 962,
                'title' => "خرم آباد",
                "province_id" => 27
            ],
            [
                "id" => 963,
                'title' => "خلیل شهر",
                "province_id" => 27
            ],
            [
                "id" => 964,
                'title' => "خوش رودپی",
                "province_id" => 27
            ],
            [
                "id" => 965,
                'title' => "دابودشت",
                "province_id" => 27
            ],
            [
                "id" => 966,
                'title' => "رامسر",
                "province_id" => 27
            ],
            [
                "id" => 967,
                'title' => "رستمکلا",
                "province_id" => 27
            ],
            [
                "id" => 968,
                'title' => "رویان",
                "province_id" => 27
            ],
            [
                "id" => 969,
                'title' => "رینه",
                "province_id" => 27
            ],
            [
                "id" => 970,
                'title' => "زرگرمحله",
                "province_id" => 27
            ],
            [
                "id" => 971,
                'title' => "زیرآب",
                "province_id" => 27
            ],
            [
                "id" => 972,
                'title' => "ساری",
                "province_id" => 27
            ],
            [
                "id" => 973,
                'title' => "سرخرود",
                "province_id" => 27
            ],
            [
                "id" => 974,
                'title' => "سلمان شهر",
                "province_id" => 27
            ],
            [
                "id" => 975,
                'title' => "سورک",
                "province_id" => 27
            ],
            [
                "id" => 976,
                'title' => "شیرگاه",
                "province_id" => 27
            ],
            [
                "id" => 977,
                'title' => "شیرود",
                "province_id" => 27
            ],
            [
                "id" => 978,
                'title' => "عباس آباد",
                "province_id" => 27
            ],
            [
                "id" => 979,
                'title' => "فریدونکنار",
                "province_id" => 27
            ],
            [
                "id" => 980,
                'title' => "فریم",
                "province_id" => 27
            ],
            [
                "id" => 981,
                'title' => "قائم شهر",
                "province_id" => 27
            ],
            [
                "id" => 982,
                'title' => "کتالم",
                "province_id" => 27
            ],
            [
                "id" => 983,
                'title' => "کلارآباد",
                "province_id" => 27
            ],
            [
                "id" => 984,
                'title' => "کلاردشت",
                "province_id" => 27
            ],
            [
                "id" => 985,
                'title' => "کله بست",
                "province_id" => 27
            ],
            [
                "id" => 986,
                'title' => "کوهی خیل",
                "province_id" => 27
            ],
            [
                "id" => 987,
                'title' => "کیاسر",
                "province_id" => 27
            ],
            [
                "id" => 988,
                'title' => "کیاکلا",
                "province_id" => 27
            ],
            [
                "id" => 989,
                'title' => "گتاب",
                "province_id" => 27
            ],
            [
                "id" => 990,
                'title' => "گزنک",
                "province_id" => 27
            ],
            [
                "id" => 991,
                'title' => "گلوگاه",
                "province_id" => 27
            ],
            [
                "id" => 992,
                'title' => "محمودآباد",
                "province_id" => 27
            ],
            [
                "id" => 993,
                'title' => "مرزن آباد",
                "province_id" => 27
            ],
            [
                "id" => 994,
                'title' => "مرزیکلا",
                "province_id" => 27
            ],
            [
                "id" => 995,
                'title' => "نشتارود",
                "province_id" => 27
            ],
            [
                "id" => 996,
                'title' => "نکا",
                "province_id" => 27
            ],
            [
                "id" => 997,
                'title' => "نور",
                "province_id" => 27
            ],
            [
                "id" => 998,
                'title' => "نوشهر",
                "province_id" => 27
            ],
            [
                "id" => 999,
                'title' => "اراک",
                "province_id" => 28
            ],
            [
                "id" => 1000,
                'title' => "آستانه",
                "province_id" => 28
            ],
            [
                "id" => 1001,
                'title' => "آشتیان",
                "province_id" => 28
            ],
            [
                "id" => 1002,
                'title' => "پرندک",
                "province_id" => 28
            ],
            [
                "id" => 1003,
                'title' => "تفرش",
                "province_id" => 28
            ],
            [
                "id" => 1004,
                'title' => "توره",
                "province_id" => 28
            ],
            [
                "id" => 1005,
                'title' => "جاورسیان",
                "province_id" => 28
            ],
            [
                "id" => 1006,
                'title' => "خشکرود",
                "province_id" => 28
            ],
            [
                "id" => 1007,
                'title' => "خمین",
                "province_id" => 28
            ],
            [
                "id" => 1008,
                'title' => "خنداب",
                "province_id" => 28
            ],
            [
                "id" => 1009,
                'title' => "داودآباد",
                "province_id" => 28
            ],
            [
                "id" => 1010,
                'title' => "دلیجان",
                "province_id" => 28
            ],
            [
                "id" => 1011,
                'title' => "رازقان",
                "province_id" => 28
            ],
            [
                "id" => 1012,
                'title' => "زاویه",
                "province_id" => 28
            ],
            [
                "id" => 1013,
                'title' => "ساروق",
                "province_id" => 28
            ],
            [
                "id" => 1014,
                'title' => "ساوه",
                "province_id" => 28
            ],
            [
                "id" => 1015,
                'title' => "سنجان",
                "province_id" => 28
            ],
            [
                "id" => 1016,
                'title' => "شازند",
                "province_id" => 28
            ],
            [
                "id" => 1017,
                'title' => "غرق آباد",
                "province_id" => 28
            ],
            [
                "id" => 1018,
                'title' => "فرمهین",
                "province_id" => 28
            ],
            [
                "id" => 1019,
                'title' => "قورچی باشی",
                "province_id" => 28
            ],
            [
                "id" => 1020,
                'title' => "کرهرود",
                "province_id" => 28
            ],
            [
                "id" => 1021,
                'title' => "کمیجان",
                "province_id" => 28
            ],
            [
                "id" => 1022,
                'title' => "مامونیه",
                "province_id" => 28
            ],
            [
                "id" => 1023,
                'title' => "محلات",
                "province_id" => 28
            ],
            [
                "id" => 1024,
                'title' => "مهاجران",
                "province_id" => 28
            ],
            [
                "id" => 1025,
                'title' => "میلاجرد",
                "province_id" => 28
            ],
            [
                "id" => 1026,
                'title' => "نراق",
                "province_id" => 28
            ],
            [
                "id" => 1027,
                'title' => "نوبران",
                "province_id" => 28
            ],
            [
                "id" => 1028,
                'title' => "نیمور",
                "province_id" => 28
            ],
            [
                "id" => 1029,
                'title' => "هندودر",
                "province_id" => 28
            ],
            [
                "id" => 1030,
                'title' => "ابوموسی",
                "province_id" => 29
            ],
            [
                "id" => 1031,
                'title' => "بستک",
                "province_id" => 29
            ],
            [
                "id" => 1032,
                'title' => "بندرجاسک",
                "province_id" => 29
            ],
            [
                "id" => 1033,
                'title' => "بندرچارک",
                "province_id" => 29
            ],
            [
                "id" => 1034,
                'title' => "بندرخمیر",
                "province_id" => 29
            ],
            [
                "id" => 1035,
                'title' => "بندرعباس",
                "province_id" => 29
            ],
            [
                "id" => 1036,
                'title' => "بندرلنگه",
                "province_id" => 29
            ],
            [
                "id" => 1037,
                'title' => "بیکا",
                "province_id" => 29
            ],
            [
                "id" => 1038,
                'title' => "پارسیان",
                "province_id" => 29
            ],
            [
                "id" => 1039,
                'title' => "تخت",
                "province_id" => 29
            ],
            [
                "id" => 1040,
                'title' => "جناح",
                "province_id" => 29
            ],
            [
                "id" => 1041,
                'title' => "حاجی آباد",
                "province_id" => 29
            ],
            [
                "id" => 1042,
                'title' => "درگهان",
                "province_id" => 29
            ],
            [
                "id" => 1043,
                'title' => "دهبارز",
                "province_id" => 29
            ],
            [
                "id" => 1044,
                'title' => "رویدر",
                "province_id" => 29
            ],
            [
                "id" => 1045,
                'title' => "زیارتعلی",
                "province_id" => 29
            ],
            [
                "id" => 1046,
                'title' => "سردشت",
                "province_id" => 29
            ],
            [
                "id" => 1047,
                'title' => "سندرک",
                "province_id" => 29
            ],
            [
                "id" => 1048,
                'title' => "سوزا",
                "province_id" => 29
            ],
            [
                "id" => 1049,
                'title' => "سیریک",
                "province_id" => 29
            ],
            [
                "id" => 1050,
                'title' => "فارغان",
                "province_id" => 29
            ],
            [
                "id" => 1051,
                'title' => "فین",
                "province_id" => 29
            ],
            [
                "id" => 1052,
                'title' => "قشم",
                "province_id" => 29
            ],
            [
                "id" => 1053,
                'title' => "قلعه قاضی",
                "province_id" => 29
            ],
            [
                "id" => 1054,
                'title' => "کنگ",
                "province_id" => 29
            ],
            [
                "id" => 1055,
                'title' => "کوشکنار",
                "province_id" => 29
            ],
            [
                "id" => 1056,
                'title' => "کیش",
                "province_id" => 29
            ],
            [
                "id" => 1057,
                'title' => "گوهران",
                "province_id" => 29
            ],
            [
                "id" => 1058,
                'title' => "میناب",
                "province_id" => 29
            ],
            [
                "id" => 1059,
                'title' => "هرمز",
                "province_id" => 29
            ],
            [
                "id" => 1060,
                'title' => "هشتبندی",
                "province_id" => 29
            ],
            [
                "id" => 1061,
                'title' => "ازندریان",
                "province_id" => 30
            ],
            [
                "id" => 1062,
                'title' => "اسدآباد",
                "province_id" => 30
            ],
            [
                "id" => 1063,
                'title' => "برزول",
                "province_id" => 30
            ],
            [
                "id" => 1064,
                'title' => "بهار",
                "province_id" => 30
            ],
            [
                "id" => 1065,
                'title' => "تویسرکان",
                "province_id" => 30
            ],
            [
                "id" => 1066,
                'title' => "جورقان",
                "province_id" => 30
            ],
            [
                "id" => 1067,
                'title' => "جوکار",
                "province_id" => 30
            ],
            [
                "id" => 1068,
                'title' => "دمق",
                "province_id" => 30
            ],
            [
                "id" => 1069,
                'title' => "رزن",
                "province_id" => 30
            ],
            [
                "id" => 1070,
                'title' => "زنگنه",
                "province_id" => 30
            ],
            [
                "id" => 1071,
                'title' => "سامن",
                "province_id" => 30
            ],
            [
                "id" => 1072,
                'title' => "سرکان",
                "province_id" => 30
            ],
            [
                "id" => 1073,
                'title' => "شیرین سو",
                "province_id" => 30
            ],
            [
                "id" => 1074,
                'title' => "صالح آباد",
                "province_id" => 30
            ],
            [
                "id" => 1075,
                'title' => "فامنین",
                "province_id" => 30
            ],
            [
                "id" => 1076,
                'title' => "فرسفج",
                "province_id" => 30
            ],
            [
                "id" => 1077,
                'title' => "فیروزان",
                "province_id" => 30
            ],
            [
                "id" => 1078,
                'title' => "قروه درجزین",
                "province_id" => 30
            ],
            [
                "id" => 1079,
                'title' => "قهاوند",
                "province_id" => 30
            ],
            [
                "id" => 1080,
                'title' => "کبودر آهنگ",
                "province_id" => 30
            ],
            [
                "id" => 1081,
                'title' => "گل تپه",
                "province_id" => 30
            ],
            [
                "id" => 1082,
                'title' => "گیان",
                "province_id" => 30
            ],
            [
                "id" => 1083,
                'title' => "لالجین",
                "province_id" => 30
            ],
            [
                "id" => 1084,
                'title' => "مریانج",
                "province_id" => 30
            ],
            [
                "id" => 1085,
                'title' => "ملایر",
                "province_id" => 30
            ],
            [
                "id" => 1086,
                'title' => "نهاوند",
                "province_id" => 30
            ],
            [
                "id" => 1087,
                'title' => "همدان",
                "province_id" => 30
            ],
            [
                "id" => 1088,
                'title' => "ابرکوه",
                "province_id" => 31
            ],
            [
                "id" => 1089,
                'title' => "احمدآباد",
                "province_id" => 31
            ],
            [
                "id" => 1090,
                'title' => "اردکان",
                "province_id" => 31
            ],
            [
                "id" => 1091,
                'title' => "اشکذر",
                "province_id" => 31
            ],
            [
                "id" => 1092,
                'title' => "بافق",
                "province_id" => 31
            ],
            [
                "id" => 1093,
                'title' => "بفروئیه",
                "province_id" => 31
            ],
            [
                "id" => 1094,
                'title' => "بهاباد",
                "province_id" => 31
            ],
            [
                "id" => 1095,
                'title' => "تفت",
                "province_id" => 31
            ],
            [
                "id" => 1096,
                'title' => "حمیدیا",
                "province_id" => 31
            ],
            [
                "id" => 1097,
                'title' => "خضرآباد",
                "province_id" => 31
            ],
            [
                "id" => 1098,
                'title' => "دیهوک",
                "province_id" => 31
            ],
            [
                "id" => 1099,
                'title' => "زارچ",
                "province_id" => 31
            ],
            [
                "id" => 1100,
                'title' => "شاهدیه",
                "province_id" => 31
            ],
            [
                "id" => 1101,
                'title' => "طبس",
                "province_id" => 31
            ],
            [
                "id" => 1103,
                'title' => "عقدا",
                "province_id" => 31
            ],
            [
                "id" => 1104,
                'title' => "مروست",
                "province_id" => 31
            ],
            [
                "id" => 1105,
                'title' => "مهردشت",
                "province_id" => 31
            ],
            [
                "id" => 1106,
                'title' => "مهریز",
                "province_id" => 31
            ],
            [
                "id" => 1107,
                'title' => "میبد",
                "province_id" => 31
            ],
            [
                "id" => 1108,
                'title' => "ندوشن",
                "province_id" => 31
            ],
            [
                "id" => 1109,
                'title' => "نیر",
                "province_id" => 31
            ],
            [
                "id" => 1110,
                'title' => "هرات",
                "province_id" => 31
            ],
            [
                "id" => 1111,
                'title' => "یزد",
                "province_id" => 31
            ],
            [
                "id" => 1116,
                'title' => "پرند",
                "province_id" => 8
            ],
            [
                "id" => 1117,
                'title' => "فردیس",
                "province_id" => 5
            ],
            [
                "id" => 1118,
                'title' => "مارلیک",
                "province_id" => 5
            ],
            [
                "id" => 1119,
                'title' => "سادات شهر",
                "province_id" => 27
            ],
            [
                "id" => 1121,
                'title' => "زیباکنار",
                "province_id" => 26
            ],
            [
                "id" => 1135,
                'title' => "کردان",
                "province_id" => 5
            ],
            [
                "id" => 1137,
                'title' => "ساوجبلاغ",
                "province_id" => 5
            ],
            [
                "id" => 1138,
                'title' => "تهران دشت",
                "province_id" => 5
            ],
            [
                "id" => 1150,
                'title' => "گلبهار",
                "province_id" => 11
            ],
            [
                "id" => 1153,
                'title' => "قیامدشت",
                "province_id" => 8
            ],
            [
                "id" => 1155,
                'title' => "بینالود",
                "province_id" => 11
            ],
            [
                "id" => 1159,
                'title' => "پیربازار",
                "province_id" => 26
            ],
            [
                "id" => 1160,
                'title' => "رضوانشهر",
                "province_id" => 31
            ]
        ];

        DB::table('cities')->insert($cities);


        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->nullable()->comment("slug");
            $table->string('email')->nullable();
            $table->string('mobile', 11)->nullable();
            $table->string('password');
            $table->tinyInteger('role')->default(Main::ROLE_ADMIN);
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('main_image')->nullable()->index();
            $table->foreignId('header_image')->nullable()->index();
            $table->tinyInteger('type')->default(Main::USER_TYPE_HAGHIGHI)->comment("حقیقی-حقوقی");
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('corporate_name')->nullable();
            $table->tinyInteger('sex')->nullable()->default(Main::USER_SEX_MALE);
            $table->string('mobile_sms', 11)->unique()->nullable();
            $table->string('phone1', 11)->nullable();
            $table->string('phone2', 11)->nullable();
            $table->string('phone3', 11)->nullable();
            $table->string('national_code', 10)->nullable();
            $table->string('economical_code', 14)->nullable();
            $table->string('register_code')->nullable();
            $table->string('website')->nullable();
            $table->date('birthday')->nullable();
            $table->text('description')->nullable()->comment("بیوگرافی");
            $table->string('address')->nullable();
            $table->string('province_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('town_id')->nullable();
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
                'mobile' => '09354818352',
                'role' => Main::ROLE_ADMIN,
                'sex' => Main::USER_SEX_MALE,
                'national_code' => '0014291789',
                'economical_code' => '00142917890001',
                'birthday' => Carbon::createFromDate(1991, 10, 12),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'سمیرا',
                'last_name' => 'وظیفه',
                'password' => Hash::make('Salam123!@'),
                'phone1' => '02188098472',
                'postal_code' => '1468683351',
                'username' => 'samiravazife',
                'email' => 'samiravazife@gmail.com',
                'mobile' => '09212788597',
                'role' => Main::ROLE_CUSTOMER,
                'sex' => Main::USER_SEX_FEMALE,
                'national_code' => '0018057856',
                'economical_code' => '00180578560001',
                'birthday' => Carbon::createFromDate(1993, 7, 8),
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
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
