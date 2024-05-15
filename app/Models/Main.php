<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    use HasFactory;

    const STATUS_DEFAULT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;
    const STATUS_DISABLED = 3;
    const STATUS_IS_DELETED = 1;
    const USER_TYPE_HAGHIGHI = 1;
    const USER_TYPE_HOGHOGHI = 2;
    const ROLE_ADMIN = 1;
    const ROLE_CUSTOMER = 2;
    const USER_SEX_MALE = 1;
    const USER_SEX_FEMALE = 2;
    const USER_SEX_OTHER = 3;

    public static function  typeList($label = false)
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

    public static  function attributesName(){
        return [
            'id'=>'شناسه',
            'first_name'=>'نام',
            'last_name'=>'نام خانوادگی',
            'corporate_name'=>'نام شرکت',
            'sex'=>'جنسیت',
            'user_description'=>'بیوگرافی',
            'address'=>'آدرس',
            'province_id'=>'استان',
            'province'=>'استان',
            'city'=>'شهر',
            'city_id'=>'شهر',
            'phone1'=>'تلفن 1',
            'phone2'=>'تلفن 2',
            'phone3'=>'تلفن 3',
            'postal_code'=>'کد پستی',
            'username'=>'نام کاربری',
            'password'=>'رمز عبور',
            'email'=>'ایمیل',
            'mobile'=>'موبایل',
            'mobile_sms'=>'موبایل جهت دریافت پیامک',
            'national_code'=>'شناسه ملی',
            'economical_code'=>'کد اقتصادی',
            'register_code'=>'شماره ثبت',
            'status'=>'وضعیت',
            'user_type'=>'نوع کاربر',
            'birthday'=>'تاریخ تولد',
            'last_login'=>'آخرین ورود',
            'last_try'=>'آخرین تلاش برای ورود',
            'failed_login_count'=>'تعداد تلاش ناموفق',
            'email_verified_at'=>'تاریخ تایید ایمیل',
            'mobile_verified_at'=>'تاریخ تایید موبایل',
            'deleted_at'=>'تاریخ حذف',
            'user_role'=>'نقش کاربر',
            'remember_token'=>'رممبر توکن',
            'created_at'=>'تاریخ ثبت',
            'updated_at'=>'تاریخ ویرایش',
            'setting'=>'تنظیمات',
            'edit'=>'ویرایش',
            'delete'=>'حذف',
            'adminLabel'=>'ادمین',
            'userLabel'=>'مشتری',
            'usersLabel'=>'مشتریان',
            'new'=>'جدید',
            'manage'=>'مدیریت',
            'adminsLabel'=>'ادمین ها',
            'create'=>'ایجاد',
            'users'=>'کاربران',
            'part'=>'بخش',
            'home'=>'خانه',
            'user'=>'کاربر',
            'Back'=>'بازگشت',
            'DropdownLabel'=>'-- انتخاب کنید --',
            'searchPlaceHolder'=>'جستجو...',
        ];
    }
}
