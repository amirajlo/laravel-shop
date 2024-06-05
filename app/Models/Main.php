<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Main extends Model
{
    use HasFactory;
    use RevisionableTrait;

    /***** START SCORE ****/
    const SCORE_ONE = 1;
    const SCORE_TWO = 2;
    const SCORE_THREE = 3;
    const SCORE_FOUR = 4;
    const SCORE_FIVE = 5;

    /***** END SCORE ****/

    /***** START PUBLIC STATUS ****/
    const STATUS_DEFAULT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;
    const STATUS_DISABLED = 3;

    /***** END PUBLIC STATUS ****/

    /***** START USER STATUS ****/
    const USER_TYPE_HAGHIGHI = 1;
    const USER_TYPE_HOGHOGHI = 2;
    const ROLE_ADMIN = 1;
    const ROLE_CUSTOMER = 2;
    const USER_SEX_MALE = 1;
    const USER_SEX_FEMALE = 2;
    const USER_SEX_OTHER = 3;
    /***** END USER STATUS ****/

    /***** START CATEGORY TYPE ****/
    const CATEGORY_TYPE_PRODUCT = 1;
    const CATEGORY_TYPE_ARTICLE = 2;
    const CATEGORY_TYPE_TICKET = 3;
    /***** END CATEGORY TYPE ****/

    /***** START STOCK  ****/
    const STOCK = 1;
    const IN_STOCK = 2;

    /***** END STOCK  ****/

    public static function categoriesTypeList($label = false)
    {
        $result = [
            self::CATEGORY_TYPE_PRODUCT => "محصولات",
            self::CATEGORY_TYPE_ARTICLE => "مقالات",
            self::CATEGORY_TYPE_TICKET => "تیکت ها",
        ];
        if ($label) {
            $result = [
                self::CATEGORY_TYPE_PRODUCT => "<label class='btn btn-primary btn-sm'>محصول</label>",
                self::CATEGORY_TYPE_ARTICLE => "<label class='btn btn-success btn-sm'>مقاله</label>",
                self::CATEGORY_TYPE_TICKET => "<label class='btn btn-info btn-sm'>تیکت</label>",
            ];
        }
        return $result;
    }

    public static function typeList($label = false)
    {
        $result = [
            self::USER_TYPE_HAGHIGHI => "حقیقی",
            self::USER_TYPE_HOGHOGHI => "حقوقی",
        ];
        if ($label) {
            $result = [
                self::USER_TYPE_HAGHIGHI => "<label class='btn btn-primary btn-sm'>حقیقی</label>",
                self::USER_TYPE_HOGHOGHI => "<label class='btn btn-success btn-sm'>حقوقی</label>",
            ];
        }
        return $result;
    }

    public static function sexList($label = false)
    {
        $result = [
            self::USER_SEX_MALE => "آقا",
            self::USER_SEX_FEMALE => "خانم",
            self::USER_SEX_OTHER => "سایر",

        ];
        if ($label) {
            $result = [
                self::USER_SEX_MALE => "<label class='btn btn-primary btn-sm'>آقا</label>",
                self::USER_SEX_FEMALE => "<label class='btn btn-success btn-sm'>خانم</label>",
                self::USER_SEX_OTHER => "<label class='btn btn-info btn-sm'>سایر</label>",

            ];
        }
        return $result;
    }


    public static function userStatus($label = false)
    {
        $result = [
            self::STATUS_DEFAULT => "غیر فعال",
            self::STATUS_ACTIVE => "فعال",
            self::STATUS_LOCKED => "قفل شده",
            self::STATUS_DISABLED => "معلق",
        ];
        if ($label) {
            $result = [
                self::STATUS_DEFAULT => "<label class='btn  btn-sm'>غیر فعال</label>",
                self::STATUS_ACTIVE => "<label class='btn btn-success btn-sm'>فعال</label>",
                self::STATUS_LOCKED => "<label class='btn btn-warning btn-sm'>قفل شده</label>",
                self::STATUS_DISABLED => "<label class='btn btn-danger btn-sm'>معلق</label>",
            ];
        }
        return $result;

    }

    public static function attributesName()
    {
        return [
            'negative_points' => 'نکات منفی',
            'positive_points' => 'نکات مثبت',
            'website' => 'سایت',
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'corporate_name' => 'نام شرکت',
            'sex' => 'جنسیت',
            'user_description' => 'بیوگرافی',
            'address' => 'آدرس',
            'province_id' => 'استان',
            'province' => 'استان',
            'score' => 'امتیاز',
            'like' => 'لایک',
            'diss_like' => 'دیس لایک',
            'city' => 'شهر',
            'city_id' => 'شهر',
            'phone1' => 'تلفن 1',
            'phone2' => 'تلفن 2',
            'phone3' => 'تلفن 3',
            'postal_code' => 'کد پستی',
            'username' => 'نام کاربری',
            'password' => 'رمز عبور',
            'email' => 'ایمیل',
            'mobile' => 'موبایل',
            'mobile_sms' => 'موبایل جهت دریافت پیامک',
            'national_code' => 'شناسه ملی',
            'economical_code' => 'کد اقتصادی',
            'register_code' => 'شماره ثبت',
            'status' => 'وضعیت',
            'user_type' => 'نوع کاربر',
            'birthday' => 'تاریخ تولد',
            'last_login' => 'آخرین ورود',
            'last_try' => 'آخرین تلاش برای ورود',
            'failed_login_count' => 'تعداد تلاش ناموفق',
            'email_verified_at' => 'تاریخ تایید ایمیل',
            'mobile_verified_at' => 'تاریخ تایید موبایل',
            'deleted_at' => 'تاریخ حذف',
            'user_role' => 'نقش کاربر',
            'remember_token' => 'رممبر توکن',
            'created_at' => 'تاریخ ثبت',
            'updated_at' => 'تاریخ ویرایش',
            'setting' => 'تنظیمات',
            'edit' => 'ویرایش',
            'delete' => 'حذف',
            'adminLabel' => 'ادمین',
            'userLabel' => 'مشتری',
            'usersLabel' => 'مشتریان',
            'new' => 'جدید',
            'manage' => 'مدیریت',
            'adminsLabel' => 'ادمین ها',
            'create' => 'ایجاد',
            'users' => 'کاربران',
            'part' => 'بخش',
            'home' => 'خانه',
            'user' => 'کاربر',
            'Back' => 'بازگشت',
            'rolessLabel' => 'نقش ها',
            'comments' => 'کامنت ها',
            'comment' => 'کامنت',
            'permissionsLabel' => 'دسترسی ها',
            'customersLabel' => 'مشتریان',
            'DropdownLabel' => '-- انتخاب کنید --',
            'searchPlaceHolder' => 'جستجو...',
            'categories_type' => 'نوع دسته بندی',
            'categories' => 'دسته بندی ها',
            'category' => 'دسته بندی',
            'tags' => 'برچسب ها',
            'tag' => 'برچسب',
            'title' => 'عنوان',
            'en_title' => 'عنوان انگلیسی',
            'slug' => 'اسلاگ',
            'content_title' => 'عنوان H1',
            'seo_title' => 'عنوان سئو',
            'seo_description' => 'توضیحات سئو',
            'description' => 'توضیحات',
            'redirect' => 'ریدایرکت',
            'canonical' => 'کنونیکال',
            'sidebar' => 'سایدبار',
            'update' => 'ویرایش',
            'sendButton' => 'ارسال',
            'createButton' => 'ثبت',
            'updateButton' => 'به روزرسانی',
            'parent_id' => 'دسته بندی',
            'brands' => 'برندها',
            'brand' => 'برند',
            'articles' => 'مقالات',
            'article' => 'مقاله',
            'sub_title' => 'عنوان فرعی',
            'lead' => 'لید',
            'products' => 'محصولات',
            'product' => 'محصول',
        ];
    }

    public static function breadCrumbs($list)
    {
        $attributesName = self::attributesName();
        $result = [
            '<li class="breadcrumb-item font-size-12"><a href="/admin">' . $attributesName['home'] . '</a></li>'
        ];


        return $result;
    }
}
