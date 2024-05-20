<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Jooyeshgar\Moadian\Invoice as MoadianInvoice;
use Jooyeshgar\Moadian\InvoiceHeader;
use Jooyeshgar\Moadian\InvoiceItem;
use Jooyeshgar\Moadian\Payment;
use Jooyeshgar\Moadian\Services\ApiClient;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class Main extends Model
{
    use HasFactory;


    const STATUS_DEFAULT = 0;
    const STATUS_DELETED = 1;

    const INVOICE_SENT = 1;
    const INVOICE_SUCCESS = 2;
    const INVOICE_FAILED = 3;
    const INVOICE_NOTFOUND = 4;
    const INVOICE_PENDING = 5;
    const INVOICE_IN_PROGRESS = 6;


    const TYPEPAYMENT_NAGHD = 1;
    const TYPEPAYMENT_NESIEH = 2;
    const TYPEPAYMENT_BOTH = 3;

    const TYPE_SUBJECT_ASLI = 1;
    const TYPE_SUBJECT_ESLAHI = 2;
    const TYPE_SUBJECT_EBTALI = 3;
    const TYPE_SUBJECT_BARGASHTI = 4;


    public static function sendInquiry($factor, $privateKey, $moadianUsername)
    {
        $check = new ApiClient($moadianUsername, $privateKey);
        $info = $check->inquiryByReferenceNumbers([$factor->referenceNumber]);
        $message = "";
        $error = 0;
        $invoiceStatus = Main::INVOICE_SENT;
        if (!empty($info)) {
            $status = $info->getStatusCode();
            $error = $info->getError();
            $body = $info->getBody()[0];
            if ($status == 200) {
                switch ($body['status']) {
                    case "SUCCESS":
                        $invoiceStatus = Main::INVOICE_SUCCESS;
                        break;
                    case "FAILED":
                        $invoiceStatus = Main::INVOICE_FAILED;
                        break;
                    case "PENDING":
                        $invoiceStatus = Main::INVOICE_PENDING;
                        break;
                    case "NOT_FOUND":
                        $invoiceStatus = Main::INVOICE_NOTFOUND;
                        break;
                    case "IN_PROGRESS":
                        $invoiceStatus = Main::INVOICE_IN_PROGRESS;
                        break;
                    default:
                        $invoiceStatus = Main::INVOICE_SENT;
                }
                $factor->status = $invoiceStatus;
                $factor->save();
                $newInquiry = new Inquiry();
                if (isset($body['data']) && !is_null($body['data'])) {
                    $data = $body['data'];
                    $newInquiry->warning = json_encode($data['warning']);
                    $newInquiry->error = json_encode($data['error']);
                    $newInquiry->success = json_encode($data['success']);
                    $newInquiry->invoice_id = $factor->id;
                    $newInquiry->save();
                }

                $message = "اطلاعات با موفقیت دریافت شد." . $body['status'];
            } else {
                $error = 1;
                $message = "";
                $message .= "مشکل در دریافت اطلاعات رخ داده است.";
                $message .= json_encode($info);
            }

        } else {
            $error = 1;
            $message = "مشکل در دریافت پاسخ از سامانه مالیاتی";
        }

        return $result = [
            'error' => $error,
            'message' => $message,
            'status' => $invoiceStatus,
        ];
    }

    public static function sendInvoice($factor, $privateKey, $moadianUsername)
    {
        $user = Auth::user();
        $error = 0;
        $Moadian = new ApiClient($moadianUsername, $privateKey);

        $sumPrdis = \App\Models\InvoiceItem::sumColumn('prdis', $factor->id);// مجموع مبلغ قبل از اعمال تخفیف
        $sumDis = \App\Models\InvoiceItem::sumColumn('dis', $factor->id);// مجموع تخفیف
        $sumAdis = \App\Models\InvoiceItem::sumColumn('adis', $factor->id);// مجموع مبلغ پس از اعمال تخفیف
        $sumVam = \App\Models\InvoiceItem::sumColumn('vam', $factor->id);// مجموع مالیات پرداختی
        $sumCap = \App\Models\InvoiceItem::sumColumn('cap', $factor->id);// مجموع واریز نقدی
        $sumInsp = \App\Models\InvoiceItem::sumColumn('insp', $factor->id);// مجموع واریز نسیه
        $sumTsstam = \App\Models\InvoiceItem::sumColumn('tsstam', $factor->id);// مجموع مبلغ پرداختی
        $invoiceId = Main::generateInvoice($factor->trn, $factor->indatim);
        $invoiceId = intval($invoiceId);

        $indatim = Carbon::parse((int)$factor->indatim)->timestamp * 1000;
        $indati2m = Carbon::parse((int)$factor->indati2m)->timestamp * 1000;
        $indati3m = Carbon::parse((int)$factor->indati2m)->timestamp * 1000;
//payment
        $iinn = null;// 5646556; // شماره سوئیچ پرداخت
        $acn = null;// 5656565;//شماره پذیرنده فروشگاهی
        $trmn = null;//54554224;// شماره پایانه
        $trn = $invoiceId; //شماره پیگیری
        $pcn = null;// "6037-9972-9856-9865";// شماره کارت پرداخت کننده صورت حساب
        $pid = null;// شماره/شناسه ملی/كد فراگیر اتباع غیر ایرانی پرداخت كننده صورتحساب
        $pdt = $indati3m;  //تاریخ و زمان پرداخت صورتحساب
////////////////////////////////////////////
        $header = new InvoiceHeader($moadianUsername);
        $header->setTaxID(Carbon::parse(date('Y-m-d H:i:s', (int)$factor->indatim)), $invoiceId);
        $header->indatim = $indatim;
        $header->indati2m = $indati2m;
        $header->inty = $factor->inty; //نوع صورتحساب نوع اول = 1 نوع دوم =2 نوع سوم = 3
        $header->inno = $invoiceId; //سریال صورتحساب داخلی حافظه مالیاتی
        $header->irtaxid = $factor->irtaxid;//شماره صورت حساب مالیاتی مرجع
        $header->inp = $factor->inp;  //الگوی صورتحساب  1 فروش 2 فروش ارزی 3 صورتحساب طلا 4 پیمانکاری 5 قبوض 6 بلیت هواپیما
        $header->ins = $factor->ins; // موضوع صورتحساب 1 اصلی 2 اصلاحی 3 ابطالی 4 برگشت از فروش
        $header->tins = $user->economical_number; // شماره اقتصادی فروشنده
        $header->tob = $factor->tob; //نوع شخص خریدار 1 حقیقی 2 حقوقی 3 مشارکت مدنی 4 اتباع غیر ایرانی 5 مصرف کننده نهایی
        $header->bid = $factor->bid;  // شماره/شناسه ملی/شناسه مشاركت مدنی/كد فراگیر خریدار
        $header->tinb = $factor->tinb;//شماره اقتصادی خریدار یا کد ملی اش
        $header->sbc = $factor->sbc; //كد شعبه فروشنده
        $header->bpc = $factor->bpc; //كد پستی خریدار
        $header->bbc = $factor->bbc;//كد شعبه خریدار
        $header->ft = $factor->ft; //نوع پرواز
        $header->bpn = $factor->bpn;//شماره گذرنامه خریدار
        $header->scln = $factor->scln;//شماره پروانه گمركی فروشنده
        $header->scc = $factor->scc; //كد گمرک محل اظهار
        $header->crn = $factor->crn;//شناسه یکتای ثبت قرارداد فروشنده
        $header->billid = $factor->billid; //شماره اشتراک/ شناسه بهره بردار قبض

        $header->tprdis = $sumPrdis;  // مجموع مبلغ قبل از كسر تخفیف
        $header->tdis = $sumDis; // مجموع تخفیفات
        $header->tadis = $sumAdis; // مجموع مبلغ پس از كسر تخفیف
        $header->tvam = $sumVam; // مجموع مالیات بر ارزش افزوده

        $header->todam = $factor->todam; // مجموع سایر مالیات، عوارض و وجوه قانونی
        $header->tbill = $sumTsstam;  // مجموع صورتحساب

        $header->setm = $factor->setm; // روش تسویه 1 نقد 2 نسیه 3 هم نقد هم نسیه
        $header->cap = $sumTsstam;  //مبلغ پرداختی نقدی
        $header->insp = $sumInsp; // مبلغ پرداختی نسیه
        $header->tvop = $sumVam; //مجموع سهم مالیات بر ارزش افزوده از پرداخت
        // $header->dpvb =  $factor->dpvb;// عدم پرداخت مالیات بر ارزش افزوده خریدار
        // $header->tax17 =  $factor->tax17;// مالیات موضوع ماده ۱۷

        $moadianInvoice = new MoadianInvoice($header);

        foreach ($factor->items as $item) {
            $body = new InvoiceItem();
            $body->sstid = $item->sstid;
            $body->sstt = $item->sstt;
            $body->mu = $item->mu;
            $body->am = $item->am;
            $body->fee = $item->fee;
            $body->cfee = $item->cfee;
            $body->cut = $item->cut;
            $body->exr = $item->exr;
            $body->prdis = $item->prdis;
            $body->dis = $item->dis;
            $body->adis = $item->adis;
            $body->vra = $item->vra;
            $body->vam = $item->vam;
            $body->odt = $item->odt;
            $body->odr = $item->odr;
            $body->odam = $item->odam;
            $body->olt = $item->olt;
            $body->olr = $item->olr;
            $body->olam = $item->olam;
            $body->consfee = $item->consfee;
            $body->spro = $item->spro;
            $body->bros = $item->bros;
            $body->tcpbs = $item->tcpbs;
            $body->cop = $item->cop;
            $body->vop = $item->vop;
            $body->bsrn = $item->bsrn;
            $body->tsstam = $item->tsstam;
            $moadianInvoice->addItem($body);
        }

        $payment = new Payment();

        $payment->iinn = $iinn;
        $payment->acn = $acn;
        $payment->trmn = $trmn;
        $payment->trn = $trn;
        $payment->pcn = $pcn;
        $payment->pid = $pid;
        $payment->pdt = $pdt;
        $moadianInvoice->addPayment($payment);
        $info = $Moadian->sendInvoice($moadianInvoice);


        if (!empty($info)) {
            $info = $info->getBody();
            $info = $info[0];
            $factor->status = Main::INVOICE_SENT;
            $factor->taxid = $header->taxid;
            $factor->uid = $info['uid'] ?? '';
            $factor->referenceNumber = $info['referenceNumber'] ?? '';
            $factor->errorCode = $info['errorCode'] ?? '';
            $factor->errorDetail = $info['errorDetail'] ?? '';
            $factor->taxResult = 'send';
            $factor->save();
            $factor->send_to_maliat = time();
            $factor->save();
            $invoiceHistory = new InvoiceHistory();
            $invoiceHistory->invoice_id = $factor->id;
            $invoiceHistory->uid = $factor->uid;
            $invoiceHistory->referenceNumber = $factor->referenceNumber;
            $invoiceHistory->errorCode = $factor->errorCode;
            $invoiceHistory->errorDetail = $factor->errorDetail;
            $invoiceHistory->created_at = $factor->send_to_maliat;
            $invoiceHistory->save();
            $message = 'فاکتور شماره' . ' ' . $factor->trn . ' ' . 'با موفقیت ارسال شد';
        } else {
            $error = 1;
            $message = "مشکل در دریافت پاسخ از سامانه مالیاتی";
        }


        return $result = [
            'error' => $error,
            'message' => $message,
            'status' => Main::INVOICE_SENT,
        ];
    }

    public static function validationPayment($vra, $adis, $cap, $insp)
    {

        $message = "مجموع مبلغ واریز نقدی و نسیه باید برابر با مجموع صورتحساب و مالیات باشد.";
        $status = 0;
        $vam = floor(($adis * $vra) / 100);
        if (($insp + $cap) == ($adis + $vam)) {
            $status = 1;
            $message = "ok";
        }


        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    public static function generateInvoice($factorId, $factorDate)
    {
        $date = date('YmdH', $factorDate);
        $count = 10 - strlen($factorId);
        $cutChar = (substr($date, 0, $count));

        $result = $cutChar . $factorId;
        return $result;
    }

    public static function checkEmpty($value)
    {
        $result = [
            'error' => 0,
            'message' => "",
            'value' => $value,
        ];
        if (empty($value)) {
            $result = [
                'error' => 1,
                'message' => "نمی تواند خالی باشد.",
                'value' => $value,
            ];
        }
        return $result;
    }

    public static function checkDate($value)
    {

        $message = "";

        $slashCount = substr_count($value, '/');
        if ($slashCount < 2) {
            $error = 1;
            $message .= "با فرمت اشتباه وارد شده است.";
        } else {
            $error = 1;
            $message .= "معتبر نیست.";
            $Date = explode('/', $value);
            if (strlen($Date[0]) == 4 && strlen($Date[1]) == 2 && (int)($Date[1]) <= 12 && (int)$Date[2] <= 31) {
                $invoiceDate = \Morilog\Jalali\CalendarUtils::toGregorian(trim($Date[0]), trim($Date[1]), trim($Date[2]));
                $convertindatim = Carbon::parse($invoiceDate[1] . "/" . $invoiceDate[2] . "/" . $invoiceDate[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
                $message = "";
                $value = trim($convertindatim);
                $error = 0;
            }

        }

        $result = [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

        return $result;
    }

    public static function checkInvoiceNumber($invoiceNumber)
    {
        $Jalalian = Jalalian::now();
        $first = CalendarUtils::toGregorian($Jalalian->getYear(), 01, 01);
        $last = CalendarUtils::toGregorian($Jalalian->getYear(), 12, 29);
        if ($Jalalian->isLeapYear()) {
            $last = CalendarUtils::toGregorian($Jalalian->getYear(), 12, 30);
        }
        $convertFirst = Carbon::parse($first[1] . "/" . $first[2] . "/" . $first[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
        $convertLast = Carbon::parse($last[1] . "/" . $last[2] . "/" . $last[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
        $hasFactor = 0;
        $user = Auth::user();
        $condition['user_id'] = $user->id;
        $condition['trn'] = $invoiceNumber;
        //   $condition[] = ['status', '!=', Main::INVOICE_SUCCESS];
        $condition['is_deleted'] = Main::STATUS_DEFAULT;
        $factor = Invoice::where($condition)->whereBetween('indatim', [$convertFirst, $convertLast])->first();

        if (!is_null($factor)) {
            $hasFactor = 1;
        }
        return $hasFactor;
    }

    public static function validateFactors($factors)
    {
        $requiredItem = ['invoiceId', 'indatim', 'sellerType', 'sellerName', 'sellerEcoNumber',
            'buyerType', 'buyerName', 'buyerEcoNumber', 'buyerNationalNumber', 'typeInvoice',
            'typePayment', 'typePattern', 'typeSubject'];

        $isNumberItem = ['sellerEcoNumber', 'sellerRegisterNumber', 'sellerNationalNumber', 'sellerPostalCode',
            'sellerPhone', 'buyerEcoNumber', 'buyerRegisterNumber', 'buyerNationalNumber', 'buyerPostalCode', 'buyerPhone'];

        $countNumberItem = ['sellerEcoNumber', 'sellerRegisterNumber', 'sellerNationalNumber', 'sellerPostalCode',
            'buyerEcoNumber', 'buyerRegisterNumber', 'buyerNationalNumber', 'buyerPostalCode'];
        $dateItem = ['indatim'];


        $newFactors = [];
        foreach ($factors as $sheet => $factor) {
            $newFactors[$sheet]['error'] = 0;
            foreach ($factor as $key => $value) {


                if ($key == "invoiceId") {

                    if (!empty($value)) {
                        $check = self::checkInvoiceNumber($value);
                        if ($check) {
                            $message = "شماره فاکتور تکراری است.";
                            $error = 1;
                            $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $error, $message, $value);

                        }
                    }
                }

                if ($key == "indatim") {

                }
                if ($key == "otherTax") {

                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, 0);
                }
                if ($key == "sellerType") {

                }

                if ($key == "sellerName") {

                }

                if ($key == "sellerEcoNumber") {

                }
                if ($key == "sellerRegisterNumber") {

                }
                if ($key == "sellerNationalNumber") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerProvince") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerCity") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerTown") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerPostalCode") {

                }
                if ($key == "sellerAddress") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerPhone") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerType") {

                }
                if ($key == "buyerName") {

                }
                if ($key == "buyerEcoNumber") {

                }
                if ($key == "buyerRegisterNumber") {

                }
                if ($key == "buyerNationalNumber") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerProvince") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerCity") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerTown") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerPostalCode") {

                }
                if ($key == "buyerAddress") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerPhone") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "typeInvoice") {

                }
                if ($key == "typePayment") {

                }
                if ($key == "typePattern") {

                }
                if ($key == "typeSubject") {

                }

                if ($key == "items") {

                }

                //required
                if (in_array($key, $requiredItem)) {
                    $check = self::checkEmpty($value);
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);

                }

                //date Validation
                if (in_array($key, $dateItem)) {

                    $check = self::checkDate($value);
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);


                }

                //invoice types Validation
                switch ($key) {
                    case "typePattern":
                        $check = self::checkTypePattern($value);
                        break;
                    case "typeSubject":
                        $check = self::checkTypeSubject($value);
                        break;
                    case "typePayment":
                        $check = self::checkTypePayment($value);
                        break;
                    case "typeInvoice":
                        $check = self::checkTypeInvoice($value);
                        break;
                    case "buyerType":
                        $check = self::checkTypeUser($value);
                        break;
                    case "sellerType":
                        $check = self::checkTypeUser($value);
                        break;

                    default:
                        $check = 0;

                }

                if ($check != 0) {
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);
                }

                //datePayment Validation
                if ($key == "datePayment") {
                    if (!empty($value)) {
                        $checkDate = self::checkDate($value);
                        $message = $checkDate['message'];
                        $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $checkDate['error'], $message, $value);
                    } else {
                        $error = 0;
                        $message = "";
                        $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $error, $message, $value);
                    }
                }

                //check number  Validation
                if (in_array($key, $isNumberItem)) {
                    $check = self::checkCountNumber($value);
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);

                }

                //check countOfNumber  Validation
                switch ($key) {
                    case "buyerPostalCode":
                        $check = self::checkCountNumber($value, 10);
                        break;
                    case "sellerPostalCode":
                        $check = self::checkCountNumber($value, 10);
                        break;
                    case "buyerNationalNumber":
                        $check = self::checkCountNumber($value, 10,11);
                        break;
                    case "sellerNationalNumber":
                        $check = self::checkCountNumber($value, 10,11);
                        break;
                    case "buyerEcoNumber":
                        $check = self::checkCountNumber($value,  11,14);
                        break;
                    case "sellerEcoNumber":
                        $check = self::checkCountNumber($value,  11,14);
                        break;
                    default:
                        $check = 0;

                }

                if ($check != 0) {
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);

                }

                if ($key == "items") {
                    $i = 0;
                    foreach ($value as $fitems) {

                        foreach ($fitems as $index => $items) {
                            if ($index == "sstid") {

                                $check = self::checkCountNumber($items, 13);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "sstt") {

                                $check = self::checkEmpty($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "am") {
                                $check = self::checkEmpty($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "mu") {

                                $check = self::checkUnitMeasurement($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "fee") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "dis") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "cap") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "insp") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                        }
                        $i++;
                    }


                }


            }
        }
        return $newFactors;
    }


    public static function addToNewFactor($newFactors, $sheet, $key, $error, $message, $value)
    {
        if (!isset($newFactors[$sheet]['error'])) {
            $newFactors[$sheet]['error'] = $error;
        } else {
            $newFactors[$sheet]['error'] += $error;
        }

        if (!isset($newFactors[$sheet][$key]['error'], $newFactors[$sheet][$key]['message'])) {
            $newFactors[$sheet][$key]['error'] = $error;
            $newFactors[$sheet][$key]['message'] = $message;
            $newFactors[$sheet][$key]['value'] = $value;
        } else {
            $newFactors[$sheet][$key]['error'] += $error;
            $newFactors[$sheet][$key]['message'] .= "***" . $message;
            $newFactors[$sheet][$key]['value'] = $value;
        }
        return $newFactors;
    }

    public static function addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $error, $message, $value)
    {
        if (!isset($newFactors[$sheet]['error'])) {
            $newFactors[$sheet]['error'] = $error;
        } else {
            $newFactors[$sheet]['error'] += $error;
        }

        if (!isset($newFactors[$sheet][$key][$i][$index]['error'], $newFactors[$sheet][$key][$i][$index]['message'])) {
            $newFactors[$sheet][$key][$i][$index]['error'] = $error;
            $newFactors[$sheet][$key][$i][$index]['message'] = $message;
            $newFactors[$sheet][$key][$i][$index]['value'] = $value;
        } else {
            $newFactors[$sheet][$key][$i][$index]['error'] += $error;
            $newFactors[$sheet][$key][$i][$index]['message'] .= "***" . $message;
            $newFactors[$sheet][$key][$i][$index]['value'] = $value;
        }
        return $newFactors;
    }

    public static function insertToDb($factors, $uploadPath, $percent = 9)
    {

        $failed = 0;
        $success = 0;
        foreach ($factors as $key => $value) {

            if ($value['error'] > 0) {
                $failed += 1;
                continue;
            } else {
                $success += 1;
            }
            $defaultMaliatValue = self::defaultMaliatValue();
            $buyerType = $defaultMaliatValue['userType'][trim($value['buyerType']['value'])];
            $typeInvoice = $defaultMaliatValue['typeInvoice'][trim($value['typeInvoice']['value'])];
            $typePayment = $defaultMaliatValue['typePayment'][trim($value['typePayment']['value'])];
            $typePattern = $defaultMaliatValue['typePattern'][trim($value['typePattern']['value'])];
            $typeSubject = $defaultMaliatValue['typeSubject'][trim($value['typeSubject']['value'])];
            $buyerCondition = [
                'economical_number' => trim($value['buyerNationalNumber']['value']),

            ];
            $hasBuyer = User::where(['national_number' => $buyerCondition['economical_number']])->orWhere(['economical_number' => $buyerCondition['economical_number']])->first();

            if (!isset($hasBuyer->id)) {
                $newUser = new User();
                $newUser->name = $value['buyerName']['value'];
                $newUser->economical_number = $value['buyerEcoNumber']['value'];
                $newUser->national_number = $value['buyerNationalNumber']['value'];
                $newUser->register_number = $value['buyerRegisterNumber']['value'];
                $newUser->phone_number = $value['buyerPhone']['value'];
                $newUser->postal_code = $value['buyerPostalCode']['value'];
                $newUser->province = $value['buyerProvince']['value'];
                $newUser->city = $value['buyerCity']['value'];
                $newUser->town = $value['buyerTown']['value'];
                $newUser->address = $value['buyerAddress']['value'];
                $newUser->role = 2;
                $newUser->save();
            }
            $model = new Invoice();
            /**************** Seller ***************/
            $model->file_path = $uploadPath;
            $model->tins = trim($value['sellerNationalNumber']['value']);
            $model->tob = $buyerType;
            $model->tinb = trim($value['buyerEcoNumber']['value']);
            $model->bid = trim($value['buyerNationalNumber']['value']);
            $model->trn = trim($value['invoiceId']['value']);
            $model->bpc = trim($value['buyerPostalCode']['value']);
            $model->inno = trim($value['invoiceId']['value']);
            $model->inty = $typeInvoice;
            $model->setm = $typePayment;
            $model->inp = $typePattern;
            $model->ins = $typeSubject;
            $model->todam = trim($value['otherTax']['value']);
            $Date = explode('/', trim($value['indatim']['value']));
            $invoiceDate = \Morilog\Jalali\CalendarUtils::toGregorian(trim($Date[0]), trim($Date[1]), trim($Date[2]));
            $convertindatim = Carbon::parse($invoiceDate[1] . "/" . $invoiceDate[2] . "/" . $invoiceDate[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
            $model->indatim = $convertindatim;
            $Date = explode('/', trim($value['indatim']['value']));
            $invoiceDate = \Morilog\Jalali\CalendarUtils::toGregorian(trim($Date[0]), trim($Date[1]), trim($Date[2]));
            $convertindatim = Carbon::parse($invoiceDate[1] . "/" . $invoiceDate[2] . "/" . $invoiceDate[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
            $model->indati2m = $convertindatim;
            $model->user_id = Auth::user()->id;
            $model->save();

            foreach ($value['items'] as $items) {

                $sstid = ($items['sstid']['value']);
                $sstt = ($items['sstt']['value']);
                $am = ($items['am']['value']);
                $fee = ($items['fee']['value']);

                $unitMeasurement = $defaultMaliatValue['ReversUnitMeasurement'][trim($items['mu']['value'])];
                $mu = $unitMeasurement;
                $dis = intval($items['dis']['value']);
                $insp = ($items['insp']['value']);
                $cap = ($items['cap']['value']);


                $item = new \App\Models\InvoiceItem();
                $item->invoice_id = $model->id;
                $item->sstid = $sstid;
                $item->sstt = $sstt;
                $item->am = $am;
                $item->fee = $fee;
                $item->mu = $mu;
                $prdis = floor($fee * $am);
                $item->prdis = $prdis;//مبلغ قبل از تخفیف
                $item->dis = $dis;//مبلغ تخفیف
                $adis = $prdis - ($dis);
                $item->adis = $adis; //مبلغ بعد از تخفیف
                $item->vra = (int)$percent; //نرخ مالیات بر ارزش افزوده
                $vra = (int)$percent; //نرخ مالیات بر ارزش افزوده
                $vam = floor(($adis * $vra) / 100);
                if ($typePayment == self::TYPEPAYMENT_NAGHD) {
                    $insp = 0;
                    $cap = $adis + ($vam);
                }
                if ($typePayment == self::TYPEPAYMENT_NESIEH) {
                    $insp = $adis + ($vam);
                    $cap = 0;
                }
                $item->vam = $vam; // مبلغ مالیات بر ارزش افزوده
                $item->vop = $vam; //مجموع سهم مالیات بر ارزش افزوده از پرداخت
                $item->cop = $cap; //مبلغ پرداختی نقدی

                $item->cap = $cap;
                $item->insp = $insp;
                $tsstam = $adis + ($vam);
                $item->tsstam = $tsstam; //مبلغ كل كالا/خدمت

                $item->save();
            }
        }
        return [
            'failed' => $failed,
            'success' => $success,
        ];
    }

    public static function loadExcel($path)
    {


        $theArray = Excel::toArray([], $path);
        $factor = [];

        foreach ($theArray as $sheet => $row) {
            foreach ($row as $key => $items) {
                if ($key == 0) {
                    $factor[$sheet]['invoiceId'] = trim($items[27]);
                    if (!isset($items[27])) {
                        break;
                    }
                } elseif ($key == 1) {
                    $factor[$sheet]['indatim'] = trim($items[27]);
                } elseif ($key == 2) {
                    continue;
                } elseif ($key == 3) {
                    $factor[$sheet]['otherTax'] = 0;
                    $factor[$sheet]['sellerType'] = trim($items[1]);
                    $factor[$sheet]['sellerName'] = trim($items[3]);
                    $factor[$sheet]['sellerEcoNumber'] = trim($items[9]);
                    $factor[$sheet]['sellerRegisterNumber'] = trim($items[20]);
                    $factor[$sheet]['sellerNationalNumber'] = trim($items[28]);
                } elseif ($key == 4) {

                    $factor[$sheet]['sellerProvince'] = trim($items[2]);
                    $factor[$sheet]['sellerCity'] = trim($items[4]);
                    $factor[$sheet]['sellerTown'] = trim($items[9]);
                    $factor[$sheet]['sellerPostalCode'] = trim($items[20]);

                } elseif ($key == 5) {

                    $factor[$sheet]['sellerAddress'] = trim($items[2]);
                    $factor[$sheet]['sellerPhone'] = trim($items[20]);

                } elseif ($key == 6) {
                    continue;
                } elseif ($key == 7) {
                    $factor[$sheet]['buyerType'] = trim($items[1]);
                    $factor[$sheet]['buyerName'] = trim($items[3]);
                    $factor[$sheet]['buyerEcoNumber'] = trim($items[9]);
                    $factor[$sheet]['buyerRegisterNumber'] = trim($items[20]);
                    $factor[$sheet]['buyerNationalNumber'] = trim($items[28]);
                } elseif ($key == 8) {
                    $factor[$sheet]['buyerProvince'] = trim($items[2]);
                    $factor[$sheet]['buyerCity'] = trim($items[4]);
                    $factor[$sheet]['buyerTown'] = trim($items[9]);
                    $factor[$sheet]['buyerPostalCode'] = trim($items[20]);

                } elseif ($key == 9) {

                    $factor[$sheet]['buyerAddress'] = trim($items[2]);
                    $factor[$sheet]['buyerPhone'] = trim($items[20]);
                } elseif ($key == 10) {
                    $factor[$sheet]['typeInvoice'] = trim($items[1]);
                    $factor[$sheet]['typePayment'] = trim($items[3]);
                    $factor[$sheet]['typePattern'] = trim($items[5]);
                    $factor[$sheet]['typeSubject'] = trim($items[11]);
                    $factor[$sheet]['datePayment'] = trim($items[27]);


                } elseif ($key == 11) {
                    continue;
                } elseif ($key == 12) {
                    continue;
                } else {

                    if (empty(trim($items[1])) && empty(trim($items[2]))) {
                        break;
                    }

                    $factor[$sheet]['items'][] = [
                        'sstid' => trim($items[1]),
                        'sstt' => trim($items[2]),
                        'am' => trim($items[5]),
                        'mu' => trim($items[6]),
                        'fee' => trim($items[8]),

                        'dis' => trim($items[15]),
                        'cap' => trim($items[19]),
                        'insp' => trim($items[22]),
                    ];

                }
            }
        }

        return $factor;
    }


    public static function invoiceStatus($label = true)
    {
        if ($label) {
            return [

                self::STATUS_DEFAULT => '<span class="label label-default">ارسال نشده</span>',
                self::INVOICE_SENT => '<span class="label label-primary">ارسال شده</span>',
                self::INVOICE_SUCCESS => '<span class="label label-success">تایید شده</span>',
                self::INVOICE_FAILED => '<span class="label label-danger">عدم تایید سامانه</span>',
                self::INVOICE_NOTFOUND => '<span class="label label-info">پیدا نشد</span>',
                self::INVOICE_PENDING => '<span class="label label-warning">در انتظار سامانه</span>',
                self::INVOICE_IN_PROGRESS => '<span class="label label-warning">درحال پردازش</span>',
            ];
        } else {
            return [
                self::STATUS_DEFAULT => 'ارسال نشده',
                self::INVOICE_SENT => 'ارسال شده',
                self::INVOICE_SUCCESS => 'تایید شده',
                self::INVOICE_FAILED => 'عدم تایید سامانه',
                self::INVOICE_NOTFOUND => 'پیدا نشد',
                self::INVOICE_PENDING => 'در انتظار سامانه',
                self::INVOICE_IN_PROGRESS => 'درحال پردازش',
            ];
        }


    }

    public static function checkTypePattern($value)
    {

        $error = 1;
        $message = "الگوی صورتحساب معتبر نیست.";
        $default = [
            'فروش' => 1,
            'فروش ارزی' => 2,
            'صورتحساب طلا' => 3,
            'پیمانکاری' => 4,
            'قبوض' => 5,
            'بلیت هواپیما' => 6,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkTypeSubject($value)
    {

        $error = 1;
        $message = "موضوع صورتحساب معتبر نیست.";
        $default = [
            'اصلی' => self::TYPE_SUBJECT_ASLI,
            'اصلاحی' => self::TYPE_SUBJECT_ESLAHI,
            'ابطالی' => self::TYPE_SUBJECT_EBTALI,
            'برگشت از فروش' => self::TYPE_SUBJECT_BARGASHTI,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkTypePayment($value)
    {

        $error = 1;
        $message = "نوع پرداخت صورتحساب معتبر نیست.";
        $default = [
            'نقد' => 1,
            'نسیه' => 2,
            'هم نقد هم نسیه' => 3,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkTypeInvoice($value)
    {

        $error = 1;
        $message = "نوع فاکتور معتبر نیست.";
        $default = [
            'نوع اول' => 1,
            'نوع دوم' => 2,
            'نوع سوم' => 3,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkCountNumber($value, $count = 0, $count2 = 0)
    {
        $error = 0;
        $message = "";
        if (!empty($value)) {
            if ($count > 0) {

                if ($count2 > 0) {
                    if (strlen($value) != $count && strlen($value) != $count2) {
                        $error = 1;
                        $message = "باید شامل" . " " . $count . " یا " . $count2 . " " . " رقم باشد.";
                    }
                } else {
                    if (strlen($value) != $count) {
                        $error = 1;
                        $message = "باید شامل" . " " . $count . " رقم باشد.";
                    }
                }
            } else {
                if (!is_numeric($value)) {
                    $error = 1;
                    $message = "به عدد وارد شود.";
                }
            }
        }

        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];
    }

    public static function checkTypeUser($value)
    {

        $error = 1;
        $message = "نوع خریدار معتبر نیست.";
        $default = [
            'حقیقی' => 1,
            'حقوقی' => 2,
            'مشارکت مدنی' => 3,
            'اتباع غیر ایرانی' => 4,
            'مصرف کننده نهایی' => 5,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkUnitMeasurement($value)
    {

        $error = 1;
        $message = "واحد اندازه گیری معتبر نیست.";
        $measurement = [
            '1611' => 'لنگه',
            '1612' => 'عدل',
            '1613' => 'جعبه',
            '1618' => 'توپ',
            '1619' => 'ست',
            '1620' => 'دست',
            '1624' => 'کارتن',
            '1627' => 'عدد',
            '1628' => 'بسته',
            '1629' => 'پاکت',
            '1631' => 'دستگاه',
            '16118' => 'مگا وات ساعت',
            '16117' => 'نوبت',
            '16108' => 'لیوان',
            '1653' => 'واحد',
            '1632' => 'فروند',
            '16116' => 'سانتی متر مربع',
            '16115' => 'سانتی متر',
            '16114' => 'قطعه',
            '16113' => 'سال',
            '16112' => 'ماه',
            '16111' => 'دقیقه',
            '16110' => 'ثانیه',
            '1676' => 'نفر',
            '1669' => 'کیلو وات ساعت',
            '16105' => 'تن کیلومتر',
            '16104' => 'روز',
            '16103' => 'ساعت',
            '16102' => 'میلی گرم',
            '16101' => 'میلی متر',
            '16100' => 'میلی لیتر',
            '1678' => 'قیراط',
            '1652' => 'شعله',
            '1616' => 'نخ',
            '1622' => 'گرم',
            '1636' => 'جام',
            '1659' => 'چلیک',
            '1665' => 'شیت',
            '168' => 'حلب',
            '1647' => 'متر مکعب',
            '1660' => 'شانه',
            '163' => 'قالب',
            '1630' => '(رول)حلقه',
            '1656' => 'بندیل',
            '1683' => 'کپسول',
            '1650' => 'ساشه',
            '1637' => 'لیتر',
            '1694' => 'قراصه(bundle)',
            '1673' => 'قراص',
            '1668' => '(رینگ)حلقه',
            '1661' => 'دوجین',
            '1649' => 'پالت',
            '1645' => 'متر مربع',
            '1643' => 'جفت',
            '1642' => 'طاقه',
            '1641' => 'رول',
            '1640' => 'تخته',
            '1689' => 'ثوب',
            '1690' => 'نیم دوجین',
            '1635' => 'قرقره',
            '164' => 'کیلوگرم',
            '1638' => 'بطری',
            '161' => 'برگ',
            '1625' => 'سطل',
            '1654' => 'ورق',
            '1646' => 'شاخه',
            '1644' => 'قوطی',
            '1617' => 'جلد',
            '162' => 'تیوب',
            '165' => 'متر',
            '1610' => 'کلاف',
            '1615' => 'کیسه',
            '1680' => 'طغرا',
            '1639' => 'بشکه',
            '1614' => 'گالن',
            '1687' => 'فاقد بسته بندی',
            '1693' => 'کارت(master case)',
            '166' => 'صفحه',
            '1666' => 'مخزن',
            '1626' => 'تانکر',
            '1648' => 'دبه',
            '1684' => 'سبد',
            '169' => 'تن',
            '1651' => 'بانکه',
            '1633' => 'سیلندر',
            '1679' => 'فوت مربع',
        ];
        $default = array_flip($measurement);

        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function defaultMaliatValue()
    {
        $typePatternArray = [
            'فروش' => 1,
            'فروش ارزی' => 2,
            'صورتحساب طلا' => 3,
            'پیمانکاری' => 4,
            'قبوض' => 5,
            'بلیت هواپیما' => 6,
        ];
        $typeSubjectArray = [
            'اصلی' => self::TYPE_SUBJECT_ASLI,
            'اصلاحی' => self::TYPE_SUBJECT_ESLAHI,
            'ابطالی' => self::TYPE_SUBJECT_EBTALI,
            'برگشت از فروش' => self::TYPE_SUBJECT_BARGASHTI,
        ];
        $typePaymentArray = [
            'نقد' => 1,
            'نسیه' => 2,
            'هم نقد هم نسیه' => 3,
        ];
        $typeInvoiceArray = [
            'نوع اول' => 1,
            'نوع دوم' => 2,
            'نوع سوم' => 3,
        ];
        $userTypeArray = [
            'حقیقی' => 1,
            'حقوقی' => 2,
            'مشارکت مدنی' => 3,
            'اتباع غیر ایرانی' => 4,
            'مصرف کننده نهایی' => 5,
        ];
        $unitMeasurementArray = [
            '1611' => 'لنگه',
            '1612' => 'عدل',
            '1613' => 'جعبه',
            '1618' => 'توپ',
            '1619' => 'ست',
            '1620' => 'دست',
            '1624' => 'کارتن',
            '1627' => 'عدد',
            '1628' => 'بسته',
            '1629' => 'پاکت',
            '1631' => 'دستگاه',
            '16118' => 'مگا وات ساعت',
            '16117' => 'نوبت',
            '16108' => 'لیوان',
            '1653' => 'واحد',
            '1632' => 'فروند',
            '16116' => 'سانتی متر مربع',
            '16115' => 'سانتی متر',
            '16114' => 'قطعه',
            '16113' => 'سال',
            '16112' => 'ماه',
            '16111' => 'دقیقه',
            '16110' => 'ثانیه',
            '1676' => 'نفر',
            '1669' => 'کیلو وات ساعت',
            '16105' => 'تن کیلومتر',
            '16104' => 'روز',
            '16103' => 'ساعت',
            '16102' => 'میلی گرم',
            '16101' => 'میلی متر',
            '16100' => 'میلی لیتر',
            '1678' => 'قیراط',
            '1652' => 'شعله',
            '1616' => 'نخ',
            '1622' => 'گرم',
            '1636' => 'جام',
            '1659' => 'چلیک',
            '1665' => 'شیت',
            '168' => 'حلب',
            '1647' => 'متر مکعب',
            '1660' => 'شانه',
            '163' => 'قالب',
            '1630' => '(رول)حلقه',
            '1656' => 'بندیل',
            '1683' => 'کپسول',
            '1650' => 'ساشه',
            '1637' => 'لیتر',
            '1694' => 'قراصه(bundle)',
            '1673' => 'قراص',
            '1668' => '(رینگ)حلقه',
            '1661' => 'دوجین',
            '1649' => 'پالت',
            '1645' => 'متر مربع',
            '1643' => 'جفت',
            '1642' => 'طاقه',
            '1641' => 'رول',
            '1640' => 'تخته',
            '1689' => 'ثوب',
            '1690' => 'نیم دوجین',
            '1635' => 'قرقره',
            '164' => 'کیلوگرم',
            '1638' => 'بطری',
            '161' => 'برگ',
            '1625' => 'سطل',
            '1654' => 'ورق',
            '1646' => 'شاخه',
            '1644' => 'قوطی',
            '1617' => 'جلد',
            '162' => 'تیوب',
            '165' => 'متر',
            '1610' => 'کلاف',
            '1615' => 'کیسه',
            '1680' => 'طغرا',
            '1639' => 'بشکه',
            '1614' => 'گالن',
            '1687' => 'فاقد بسته بندی',
            '1693' => 'کارت(master case)',
            '166' => 'صفحه',
            '1666' => 'مخزن',
            '1626' => 'تانکر',
            '1648' => 'دبه',
            '1684' => 'سبد',
            '169' => 'تن',
            '1651' => 'بانکه',
            '1633' => 'سیلندر',
            '1679' => 'فوت مربع',
        ];

        return [
            'typePattern' => $typePatternArray,
            'typeSubject' => $typeSubjectArray,
            'typePayment' => $typePaymentArray,
            'typeInvoice' => $typeInvoiceArray,
            'userType' => $userTypeArray,
            'unitMeasurement' => $unitMeasurementArray,
            'ReversUnitMeasurement' => array_flip($unitMeasurementArray),
        ];
    }

    public static function maliatLabelName()
    {
        return [
            'send_to_moadian' => 'تاریخ ارسال به سامانه',
            'trn' => 'شماره فاکتور',
            'parent_id' => 'فاکتور مرجع',
            'created_at' => 'تاریخ ثبت',
            'updated_at' => 'تاریخ ویرایش',
            'indatim' => 'تاریخ صدور',
            'indatim2' => 'تاریخ صدور',
            'inty' => 'نوع فاکتور',
            'inno' => 'شماره فاکتور',
            'inp' => 'الگوی صورت حساب',
            'ins' => 'موضوع صورت حساب',
            'tins' => 'شماره اقتصادی فروشنده',
            'tob' => 'نوع خریدار',
            'bid' => 'شماره/شناسه ملی/شناسه مشاركت مدنی/كد فراگیر خریدار',
            'tinb' => 'شماره اقتصادی خریدار یا کد ملی اش',
            'bpc' => 'كد پستی خریدار',
            'tprdis' => ' مجموع مبلغ قبل از كسر تخفیف',
            'tdis' => 'مجموع تخفیفات',
            'tadis' => ' مجموع مبلغ پس از كسر تخفیف',
            'tvam' => 'مجموع مالیات بر ارزش افزوده',
            'todam' => 'مجموع سایر مالیات، عوارض و وجوه قانونی',
            'tbill' => 'مجموع صورتحساب',
            'setm' => 'روش تسویه',
            'cap' => 'مبلغ پرداختی نقدی',
            'insp' => 'مبلغ پرداختی نسیه',
            'tvop' => 'مجموع سهم مالیات بر ارزش افزوده از پرداخت',
            'dpvb' => 'عدم پرداخت مالیات بر ارزش افزوده خریدار',
            'tax17' => ' مالیات موضوع ماده ۱۷',
            //invoce Item
            'sstid' => 'شناسه كالا/خدمت',
            'sstt' => 'شرح كالا/خدمت',
            'mu' => 'واحد اندازه گیری',
            'am' => 'تعداد / مقدار',
            'fee' => 'مبلغ واحد',
            'cfee' => 'میزان ارز',
            'cut' => 'نوع ارز',
            'exr' => 'نرخ برابری ارز با ریال',
            'prdis' => 'مبلغ قبل از تخفیف',
            'dis' => 'مبلغ تخفیف',
            'adis' => 'مبلغ بعد از تخفیف',
            'vra' => 'نرخ مالیات بر ارزش افزوده',
            'vam' => 'مبلغ مالیات بر ارزش افزوده',
            'odt' => 'موضوع سایر مالیات و عوارض',
            'odr' => 'نرخ سایر مالیات و عوارض',
            'odam' => 'مبلغ سایر مالیات و عوارض',
            'olt' => 'موضوع سایر وجوه قانونی',
            'olr' => 'نرخ سایر وجوه قانونی',
            'olam' => 'مبلغ سایر وجوه قانونی',
            'consfee' => 'اجرت ساخت',
            'spro' => 'سود فروشنده',
            'bros' => 'حق العمل',
            'tcpbs' => 'جمع کل اجرتُ حق العمل و سود',
            'cop' => 'مبلغ پرداختی نقدی',
            'vop' => 'مجموع سهم مالیات بر ارزش افزوده از پرداخت',
            'bsrn' => 'شناسه یکتای ثبت قرارداد حق العملکاری',
            'tsstam' => 'مبلغ كل كالا/خدمت',
            //payment
            'iinn' => 'شماره سوئیچ پرداخت',
            'acn' => 'شماره پذیرنده فروشگاهی',
            'trmn' => 'شماره پایانه',
            'pcn' => 'شماره کارت پرداخت کننده صورت حساب',
            'pid' => 'شماره/شناسه ملی/كد فراگیر اتباع غیر ایرانی پرداخت كننده صورتحساب',
            'pdt' => 'تاریخ و زمان پرداخت صورتحساب',
            'uid' => 'uid',
            'referenceNumber' => 'referenceNumber',

        ];
    }


    public static function getMoadianPrivateKey($keyName)
    {
        $privateKey = file_get_contents(public_path("uploads/keys/" . $keyName));
        return $privateKey;
    }

}


--------------------------



namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Jooyeshgar\Moadian\Invoice as MoadianInvoice;
use Jooyeshgar\Moadian\InvoiceHeader;
use Jooyeshgar\Moadian\InvoiceItem;
use Jooyeshgar\Moadian\Payment;
use Jooyeshgar\Moadian\Services\ApiClient;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class Main extends Model
{
    use HasFactory;


    const STATUS_DEFAULT = 0;
    const STATUS_DELETED = 1;

    const INVOICE_SENT = 1;
    const INVOICE_SUCCESS = 2;
    const INVOICE_FAILED = 3;
    const INVOICE_NOTFOUND = 4;
    const INVOICE_PENDING = 5;
    const INVOICE_IN_PROGRESS = 6;


    const TYPEPAYMENT_NAGHD = 1;
    const TYPEPAYMENT_NESIEH = 2;
    const TYPEPAYMENT_BOTH = 3;

    const TYPE_SUBJECT_ASLI = 1;
    const TYPE_SUBJECT_ESLAHI = 2;
    const TYPE_SUBJECT_EBTALI = 3;
    const TYPE_SUBJECT_BARGASHTI = 4;


    public static function sendInquiry($factor, $privateKey, $moadianUsername)
    {
        $check = new ApiClient($moadianUsername, $privateKey);
        $info = $check->inquiryByReferenceNumbers([$factor->referenceNumber]);
        $message = "";
        $error = 0;
        $invoiceStatus = Main::INVOICE_SENT;
        if (!empty($info)) {
            $status = $info->getStatusCode();
            $error = $info->getError();
            $body = $info->getBody()[0];
            if ($status == 200) {
                switch ($body['status']) {
                    case "SUCCESS":
                        $invoiceStatus = Main::INVOICE_SUCCESS;
                        break;
                    case "FAILED":
                        $invoiceStatus = Main::INVOICE_FAILED;
                        break;
                    case "PENDING":
                        $invoiceStatus = Main::INVOICE_PENDING;
                        break;
                    case "NOT_FOUND":
                        $invoiceStatus = Main::INVOICE_NOTFOUND;
                        break;
                    case "IN_PROGRESS":
                        $invoiceStatus = Main::INVOICE_IN_PROGRESS;
                        break;
                    default:
                        $invoiceStatus = Main::INVOICE_SENT;
                }
                $factor->status = $invoiceStatus;
                $factor->save();
                $newInquiry = new Inquiry();
                if (isset($body['data']) && !is_null($body['data'])) {
                    $data = $body['data'];
                    $newInquiry->warning = json_encode($data['warning']);
                    $newInquiry->error = json_encode($data['error']);
                    $newInquiry->success = json_encode($data['success']);
                    $newInquiry->invoice_id = $factor->id;
                    $newInquiry->save();
                }

                $message = "اطلاعات با موفقیت دریافت شد." . $body['status'];
            } else {
                $error = 1;
                $message = "";
                $message .= "مشکل در دریافت اطلاعات رخ داده است.";
                $message .= json_encode($info);
            }

        } else {
            $error = 1;
            $message = "مشکل در دریافت پاسخ از سامانه مالیاتی";
        }

        return $result = [
            'error' => $error,
            'message' => $message,
            'status' => $invoiceStatus,
        ];
    }

    public static function sendInvoice($factor, $privateKey, $moadianUsername)
    {
        $user = Auth::user();
        $error = 0;
        $Moadian = new ApiClient($moadianUsername, $privateKey);

        $sumPrdis = \App\Models\InvoiceItem::sumColumn('prdis', $factor->id);// مجموع مبلغ قبل از اعمال تخفیف
        $sumDis = \App\Models\InvoiceItem::sumColumn('dis', $factor->id);// مجموع تخفیف
        $sumAdis = \App\Models\InvoiceItem::sumColumn('adis', $factor->id);// مجموع مبلغ پس از اعمال تخفیف
        $sumVam = \App\Models\InvoiceItem::sumColumn('vam', $factor->id);// مجموع مالیات پرداختی
        $sumCap = \App\Models\InvoiceItem::sumColumn('cap', $factor->id);// مجموع واریز نقدی
        $sumInsp = \App\Models\InvoiceItem::sumColumn('insp', $factor->id);// مجموع واریز نسیه
        $sumTsstam = \App\Models\InvoiceItem::sumColumn('tsstam', $factor->id);// مجموع مبلغ پرداختی
        $invoiceId = Main::generateInvoice($factor->trn, $factor->indatim);
        $invoiceId = intval($invoiceId);

        $indatim = Carbon::parse((int)$factor->indatim)->timestamp * 1000;
        $indati2m = Carbon::parse((int)$factor->indati2m)->timestamp * 1000;
        $indati3m = Carbon::parse((int)$factor->indati2m)->timestamp * 1000;
//payment
        $iinn = null;// 5646556; // شماره سوئیچ پرداخت
        $acn = null;// 5656565;//شماره پذیرنده فروشگاهی
        $trmn = null;//54554224;// شماره پایانه
        $trn = $invoiceId; //شماره پیگیری
        $pcn = null;// "6037-9972-9856-9865";// شماره کارت پرداخت کننده صورت حساب
        $pid = null;// شماره/شناسه ملی/كد فراگیر اتباع غیر ایرانی پرداخت كننده صورتحساب
        $pdt = $indati3m;  //تاریخ و زمان پرداخت صورتحساب
////////////////////////////////////////////
        $header = new InvoiceHeader($moadianUsername);
        $header->setTaxID(Carbon::parse(date('Y-m-d H:i:s', (int)$factor->indatim)), $invoiceId);
        $header->indatim = $indatim;
        $header->indati2m = $indati2m;
        $header->inty = $factor->inty; //نوع صورتحساب نوع اول = 1 نوع دوم =2 نوع سوم = 3
        $header->inno = $invoiceId; //سریال صورتحساب داخلی حافظه مالیاتی
        $header->irtaxid = $factor->irtaxid;//شماره صورت حساب مالیاتی مرجع
        $header->inp = $factor->inp;  //الگوی صورتحساب  1 فروش 2 فروش ارزی 3 صورتحساب طلا 4 پیمانکاری 5 قبوض 6 بلیت هواپیما
        $header->ins = $factor->ins; // موضوع صورتحساب 1 اصلی 2 اصلاحی 3 ابطالی 4 برگشت از فروش
        $header->tins = $user->economical_number; // شماره اقتصادی فروشنده
        $header->tob = $factor->tob; //نوع شخص خریدار 1 حقیقی 2 حقوقی 3 مشارکت مدنی 4 اتباع غیر ایرانی 5 مصرف کننده نهایی
        $header->bid = $factor->bid;  // شماره/شناسه ملی/شناسه مشاركت مدنی/كد فراگیر خریدار
        $header->tinb = $factor->tinb;//شماره اقتصادی خریدار یا کد ملی اش
        $header->sbc = $factor->sbc; //كد شعبه فروشنده
        $header->bpc = $factor->bpc; //كد پستی خریدار
        $header->bbc = $factor->bbc;//كد شعبه خریدار
        $header->ft = $factor->ft; //نوع پرواز
        $header->bpn = $factor->bpn;//شماره گذرنامه خریدار
        $header->scln = $factor->scln;//شماره پروانه گمركی فروشنده
        $header->scc = $factor->scc; //كد گمرک محل اظهار
        $header->crn = $factor->crn;//شناسه یکتای ثبت قرارداد فروشنده
        $header->billid = $factor->billid; //شماره اشتراک/ شناسه بهره بردار قبض

        $header->tprdis = $sumPrdis;  // مجموع مبلغ قبل از كسر تخفیف
        $header->tdis = $sumDis; // مجموع تخفیفات
        $header->tadis = $sumAdis; // مجموع مبلغ پس از كسر تخفیف
        $header->tvam = $sumVam; // مجموع مالیات بر ارزش افزوده

        $header->todam = $factor->todam; // مجموع سایر مالیات، عوارض و وجوه قانونی
        $header->tbill = $sumTsstam;  // مجموع صورتحساب

        $header->setm = $factor->setm; // روش تسویه 1 نقد 2 نسیه 3 هم نقد هم نسیه
        $header->cap = $sumTsstam;  //مبلغ پرداختی نقدی
        $header->insp = $sumInsp; // مبلغ پرداختی نسیه
        $header->tvop = $sumVam; //مجموع سهم مالیات بر ارزش افزوده از پرداخت
        // $header->dpvb =  $factor->dpvb;// عدم پرداخت مالیات بر ارزش افزوده خریدار
        // $header->tax17 =  $factor->tax17;// مالیات موضوع ماده ۱۷

        $moadianInvoice = new MoadianInvoice($header);

        foreach ($factor->items as $item) {
            $body = new InvoiceItem();
            $body->sstid = $item->sstid;
            $body->sstt = $item->sstt;
            $body->mu = $item->mu;
            $body->am = $item->am;
            $body->fee = $item->fee;
            $body->cfee = $item->cfee;
            $body->cut = $item->cut;
            $body->exr = $item->exr;
            $body->prdis = $item->prdis;
            $body->dis = $item->dis;
            $body->adis = $item->adis;
            $body->vra = $item->vra;
            $body->vam = $item->vam;
            $body->odt = $item->odt;
            $body->odr = $item->odr;
            $body->odam = $item->odam;
            $body->olt = $item->olt;
            $body->olr = $item->olr;
            $body->olam = $item->olam;
            $body->consfee = $item->consfee;
            $body->spro = $item->spro;
            $body->bros = $item->bros;
            $body->tcpbs = $item->tcpbs;
            $body->cop = $item->cop;
            $body->vop = $item->vop;
            $body->bsrn = $item->bsrn;
            $body->tsstam = $item->tsstam;
            $moadianInvoice->addItem($body);
        }

        $payment = new Payment();

        $payment->iinn = $iinn;
        $payment->acn = $acn;
        $payment->trmn = $trmn;
        $payment->trn = $trn;
        $payment->pcn = $pcn;
        $payment->pid = $pid;
        $payment->pdt = $pdt;
        $moadianInvoice->addPayment($payment);
        $info = $Moadian->sendInvoice($moadianInvoice);


        if (!empty($info)) {
            $info = $info->getBody();
            $info = $info[0];
            $factor->status = Main::INVOICE_SENT;
            $factor->taxid = $header->taxid;
            $factor->uid = $info['uid'] ?? '';
            $factor->referenceNumber = $info['referenceNumber'] ?? '';
            $factor->errorCode = $info['errorCode'] ?? '';
            $factor->errorDetail = $info['errorDetail'] ?? '';
            $factor->taxResult = 'send';
            $factor->save();
            $factor->send_to_maliat = time();
            $factor->save();
            $invoiceHistory = new InvoiceHistory();
            $invoiceHistory->invoice_id = $factor->id;
            $invoiceHistory->uid = $factor->uid;
            $invoiceHistory->referenceNumber = $factor->referenceNumber;
            $invoiceHistory->errorCode = $factor->errorCode;
            $invoiceHistory->errorDetail = $factor->errorDetail;
            $invoiceHistory->created_at = $factor->send_to_maliat;
            $invoiceHistory->save();
            $message = 'فاکتور شماره' . ' ' . $factor->trn . ' ' . 'با موفقیت ارسال شد';
        } else {
            $error = 1;
            $message = "مشکل در دریافت پاسخ از سامانه مالیاتی";
        }


        return $result = [
            'error' => $error,
            'message' => $message,
            'status' => Main::INVOICE_SENT,
        ];
    }

    public static function validationPayment($vra, $adis, $cap, $insp)
    {

        $message = "مجموع مبلغ واریز نقدی و نسیه باید برابر با مجموع صورتحساب و مالیات باشد.";
        $status = 0;
        $adisXvra = self::roundDown($adis, $vra);
        $vam = self::roundDown($adisXvra, 100, false);
        if (($insp + $cap) == ($adis + $vam)) {
            $status = 1;
            $message = "ok";
        }


        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    public static function generateInvoice($factorId, $factorDate)
    {
        $date = date('YmdH', $factorDate);
        $count = 10 - strlen($factorId);
        $cutChar = (substr($date, 0, $count));

        $result = $cutChar . $factorId;
        return $result;
    }

    public static function checkEmpty($value)
    {
        $result = [
            'error' => 0,
            'message' => "",
            'value' => $value,
        ];
        if (empty($value)) {
            $result = [
                'error' => 1,
                'message' => "نمی تواند خالی باشد.",
                'value' => $value,
            ];
        }
        return $result;
    }

    public static function checkDate($value)
    {

        $message = "";

        $slashCount = substr_count($value, '/');
        if ($slashCount < 2) {
            $error = 1;
            $message .= "با فرمت اشتباه وارد شده است.";
        } else {
            $error = 1;
            $message .= "معتبر نیست.";
            $Date = explode('/', $value);
            if (strlen($Date[0]) == 4 && strlen($Date[1]) == 2 && (int)($Date[1]) <= 12 && (int)$Date[2] <= 31) {
                $invoiceDate = \Morilog\Jalali\CalendarUtils::toGregorian(trim($Date[0]), trim($Date[1]), trim($Date[2]));
                $convertindatim = Carbon::parse($invoiceDate[1] . "/" . $invoiceDate[2] . "/" . $invoiceDate[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
                $message = "";
                $value = trim($convertindatim);
                $error = 0;
            }

        }

        $result = [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

        return $result;
    }

    public static function checkInvoiceNumber($invoiceNumber)
    {
        $Jalalian = Jalalian::now();
        $first = CalendarUtils::toGregorian($Jalalian->getYear(), 01, 01);
        $last = CalendarUtils::toGregorian($Jalalian->getYear(), 12, 29);
        if ($Jalalian->isLeapYear()) {
            $last = CalendarUtils::toGregorian($Jalalian->getYear(), 12, 30);
        }
        $convertFirst = Carbon::parse($first[1] . "/" . $first[2] . "/" . $first[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
        $convertLast = Carbon::parse($last[1] . "/" . $last[2] . "/" . $last[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
        $hasFactor = 0;
        $user = Auth::user();
        $condition['user_id'] = $user->id;
        $condition['trn'] = $invoiceNumber;
        //   $condition[] = ['status', '!=', Main::INVOICE_SUCCESS];
        $condition['is_deleted'] = Main::STATUS_DEFAULT;
        $factor = Invoice::where($condition)->whereBetween('indatim', [$convertFirst, $convertLast])->first();

        if (!is_null($factor)) {
            $hasFactor = 1;
        }
        return $hasFactor;
    }

    public static function validateFactors($factors)
    {
        $requiredItem = ['invoiceId', 'indatim', 'sellerType', 'sellerName', 'sellerEcoNumber',
            'buyerType', 'buyerName', 'buyerEcoNumber', 'buyerNationalNumber', 'typeInvoice',
            'typePayment', 'typePattern', 'typeSubject'];

        $isNumberItem = ['sellerEcoNumber', 'sellerRegisterNumber', 'sellerNationalNumber', 'sellerPostalCode',
            'sellerPhone', 'buyerEcoNumber', 'buyerRegisterNumber', 'buyerNationalNumber', 'buyerPostalCode', 'buyerPhone'];

        $countNumberItem = ['sellerEcoNumber', 'sellerRegisterNumber', 'sellerNationalNumber', 'sellerPostalCode',
            'buyerEcoNumber', 'buyerRegisterNumber', 'buyerNationalNumber', 'buyerPostalCode'];
        $dateItem = ['indatim'];


        $newFactors = [];
        foreach ($factors as $sheet => $factor) {
            $newFactors[$sheet]['error'] = 0;
            foreach ($factor as $key => $value) {


                if ($key == "invoiceId") {

                    if (!empty($value)) {
                        $check = self::checkInvoiceNumber($value);
                        if ($check) {
                            $message = "شماره فاکتور تکراری است.";
                            $error = 1;
                            $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $error, $message, $value);

                        }
                    }
                }

                if ($key == "indatim") {

                }
                if ($key == "otherTax") {

                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, 0);
                }
                if ($key == "sellerType") {

                }

                if ($key == "sellerName") {

                }

                if ($key == "sellerEcoNumber") {

                }
                if ($key == "sellerRegisterNumber") {

                }
                if ($key == "sellerNationalNumber") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerProvince") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerCity") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerTown") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerPostalCode") {

                }
                if ($key == "sellerAddress") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "sellerPhone") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerType") {

                }
                if ($key == "buyerName") {

                }
                if ($key == "buyerEcoNumber") {

                }
                if ($key == "buyerRegisterNumber") {

                }
                if ($key == "buyerNationalNumber") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerProvince") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerCity") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerTown") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerPostalCode") {

                }
                if ($key == "buyerAddress") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "buyerPhone") {
                    $message = "";
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, 0, $message, $value);
                }
                if ($key == "typeInvoice") {

                }
                if ($key == "typePayment") {

                }
                if ($key == "typePattern") {

                }
                if ($key == "typeSubject") {

                }

                if ($key == "items") {

                }

                //required
                if (in_array($key, $requiredItem)) {
                    $check = self::checkEmpty($value);
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);

                }

                //date Validation
                if (in_array($key, $dateItem)) {

                    $check = self::checkDate($value);
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);


                }

                //invoice types Validation
                switch ($key) {
                    case "typePattern":
                        $check = self::checkTypePattern($value);
                        break;
                    case "typeSubject":
                        $check = self::checkTypeSubject($value);
                        break;
                    case "typePayment":
                        $check = self::checkTypePayment($value);
                        break;
                    case "typeInvoice":
                        $check = self::checkTypeInvoice($value);
                        break;
                    case "buyerType":
                        $check = self::checkTypeUser($value);
                        break;
                    case "sellerType":
                        $check = self::checkTypeUser($value);
                        break;

                    default:
                        $check = 0;

                }

                if ($check != 0) {
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);
                }

                //datePayment Validation
                if ($key == "datePayment") {
                    if (!empty($value)) {
                        $checkDate = self::checkDate($value);
                        $message = $checkDate['message'];
                        $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $checkDate['error'], $message, $value);
                    } else {
                        $error = 0;
                        $message = "";
                        $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $error, $message, $value);
                    }
                }

                //check number  Validation
                if (in_array($key, $isNumberItem)) {
                    $check = self::checkCountNumber($value);
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);

                }

                //check countOfNumber  Validation
                switch ($key) {
                    case "buyerPostalCode":
                        $check = self::checkCountNumber($value, 10);
                        break;
                    case "sellerPostalCode":
                        $check = self::checkCountNumber($value, 10);
                        break;
                    case "buyerNationalNumber":
                        $check = self::checkCountNumber($value, 10, 11);
                        break;
                    case "sellerNationalNumber":
                        $check = self::checkCountNumber($value, 10, 11);
                        break;
                    case "buyerEcoNumber":
                        $check = self::checkCountNumber($value, 11, 14);
                        break;
                    case "sellerEcoNumber":
                        $check = self::checkCountNumber($value, 11, 14);
                        break;
                    default:
                        $check = 0;

                }

                if ($check != 0) {
                    $message = $check['message'];
                    $newFactors = self::addToNewFactor($newFactors, $sheet, $key, $check['error'], $message, $value);

                }

                if ($key == "items") {
                    $i = 0;
                    foreach ($value as $fitems) {

                        foreach ($fitems as $index => $items) {
                            if ($index == "sstid") {

                                $check = self::checkCountNumber($items, 13);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "sstt") {

                                $check = self::checkEmpty($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "am") {
                                $check = self::checkEmpty($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "mu") {

                                $check = self::checkUnitMeasurement($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "fee") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "dis") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "cap") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                            if ($index == "insp") {
                                $check = self::checkCountNumber($items);
                                $message = $check['message'];
                                $newFactors = self::addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $check['error'], $message, $items);
                            }
                        }
                        $i++;
                    }


                }


            }
        }
        return $newFactors;
    }


    public static function addToNewFactor($newFactors, $sheet, $key, $error, $message, $value)
    {
        if (!isset($newFactors[$sheet]['error'])) {
            $newFactors[$sheet]['error'] = $error;
        } else {
            $newFactors[$sheet]['error'] += $error;
        }

        if (!isset($newFactors[$sheet][$key]['error'], $newFactors[$sheet][$key]['message'])) {
            $newFactors[$sheet][$key]['error'] = $error;
            $newFactors[$sheet][$key]['message'] = $message;
            $newFactors[$sheet][$key]['value'] = $value;
        } else {
            $newFactors[$sheet][$key]['error'] += $error;
            $newFactors[$sheet][$key]['message'] .= "***" . $message;
            $newFactors[$sheet][$key]['value'] = $value;
        }
        return $newFactors;
    }

    public static function addToNewFactorItem($newFactors, $sheet, $key, $i, $index, $error, $message, $value)
    {
        if (!isset($newFactors[$sheet]['error'])) {
            $newFactors[$sheet]['error'] = $error;
        } else {
            $newFactors[$sheet]['error'] += $error;
        }

        if (!isset($newFactors[$sheet][$key][$i][$index]['error'], $newFactors[$sheet][$key][$i][$index]['message'])) {
            $newFactors[$sheet][$key][$i][$index]['error'] = $error;
            $newFactors[$sheet][$key][$i][$index]['message'] = $message;
            $newFactors[$sheet][$key][$i][$index]['value'] = $value;
        } else {
            $newFactors[$sheet][$key][$i][$index]['error'] += $error;
            $newFactors[$sheet][$key][$i][$index]['message'] .= "***" . $message;
            $newFactors[$sheet][$key][$i][$index]['value'] = $value;
        }
        return $newFactors;
    }

    public static function insertToDb($factors, $uploadPath, $percent = 9)
    {

        $failed = 0;
        $success = 0;
        foreach ($factors as $key => $value) {

            if ($value['error'] > 0) {
                $failed += 1;
                continue;
            } else {
                $success += 1;
            }
            $defaultMaliatValue = self::defaultMaliatValue();
            $buyerType = $defaultMaliatValue['userType'][trim($value['buyerType']['value'])];
            $typeInvoice = $defaultMaliatValue['typeInvoice'][trim($value['typeInvoice']['value'])];
            $typePayment = $defaultMaliatValue['typePayment'][trim($value['typePayment']['value'])];
            $typePattern = $defaultMaliatValue['typePattern'][trim($value['typePattern']['value'])];
            $typeSubject = $defaultMaliatValue['typeSubject'][trim($value['typeSubject']['value'])];
            $buyerCondition = [
                'economical_number' => trim($value['buyerNationalNumber']['value']),

            ];
            $hasBuyer = User::where(['national_number' => $buyerCondition['economical_number']])->orWhere(['economical_number' => $buyerCondition['economical_number']])->first();

            if (!isset($hasBuyer->id)) {
                $newUser = new User();
                $newUser->name = $value['buyerName']['value'];
                $newUser->economical_number = $value['buyerEcoNumber']['value'];
                $newUser->national_number = $value['buyerNationalNumber']['value'];
                $newUser->register_number = $value['buyerRegisterNumber']['value'];
                $newUser->phone_number = $value['buyerPhone']['value'];
                $newUser->postal_code = $value['buyerPostalCode']['value'];
                $newUser->province = $value['buyerProvince']['value'];
                $newUser->city = $value['buyerCity']['value'];
                $newUser->town = $value['buyerTown']['value'];
                $newUser->address = $value['buyerAddress']['value'];
                $newUser->role = 2;
                $newUser->save();
            }
            $model = new Invoice();
            /**************** Seller ***************/
            $model->file_path = $uploadPath;
            $model->tins = trim($value['sellerNationalNumber']['value']);
            $model->tob = $buyerType;
            $model->tinb = trim($value['buyerEcoNumber']['value']);
            $model->bid = trim($value['buyerNationalNumber']['value']);
            $model->trn = trim($value['invoiceId']['value']);
            $model->bpc = trim($value['buyerPostalCode']['value']);
            $model->inno = trim($value['invoiceId']['value']);
            $model->inty = $typeInvoice;
            $model->setm = $typePayment;
            $model->inp = $typePattern;
            $model->ins = $typeSubject;
            $model->todam = trim($value['otherTax']['value']);
            $Date = explode('/', trim($value['indatim']['value']));
            $invoiceDate = \Morilog\Jalali\CalendarUtils::toGregorian(trim($Date[0]), trim($Date[1]), trim($Date[2]));
            $convertindatim = Carbon::parse($invoiceDate[1] . "/" . $invoiceDate[2] . "/" . $invoiceDate[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
            $model->indatim = $convertindatim;
            $Date = explode('/', trim($value['indatim']['value']));
            $invoiceDate = \Morilog\Jalali\CalendarUtils::toGregorian(trim($Date[0]), trim($Date[1]), trim($Date[2]));
            $convertindatim = Carbon::parse($invoiceDate[1] . "/" . $invoiceDate[2] . "/" . $invoiceDate[0] . " " . "00" . ":" . "00" . ":" . "00")->timestamp;
            $model->indati2m = $convertindatim;
            $model->user_id = Auth::user()->id;
            $model->save();

            foreach ($value['items'] as $items) {

                $sstid = ($items['sstid']['value']);
                $sstt = ($items['sstt']['value']);
                $am = ($items['am']['value']);
                $fee = ($items['fee']['value']);

                $unitMeasurement = $defaultMaliatValue['ReversUnitMeasurement'][trim($items['mu']['value'])];
                $mu = $unitMeasurement;
                $dis = intval($items['dis']['value']);
                $insp = ($items['insp']['value']);
                $cap = ($items['cap']['value']);


                $item = new \App\Models\InvoiceItem();
                $item->invoice_id = $model->id;
                $item->sstid = $sstid;
                $item->sstt = $sstt;
                $item->am = $am;
                $item->fee = $fee;
                $item->mu = $mu;
                $feeXam = self::roundDown($fee, $am);

                $prdis = $feeXam;
                $item->prdis = $prdis;//مبلغ قبل از تخفیف
                $item->dis = $dis;//مبلغ تخفیف
                $adis = $prdis - ($dis);
                $item->adis = $adis; //مبلغ بعد از تخفیف
                $item->vra = (int)$percent; //نرخ مالیات بر ارزش افزوده
                $vra = (int)$percent; //نرخ مالیات بر ارزش افزوده
                $adisXvra = self::roundDown($adis, $vra);
                $vam = self::roundDown($adisXvra, 100, false);

                if ($typePayment == self::TYPEPAYMENT_NAGHD) {
                    $insp = 0;
                    $cap = $adis + ($vam);
                }
                if ($typePayment == self::TYPEPAYMENT_NESIEH) {
                    $insp = $adis + ($vam);
                    $cap = 0;
                }
                $item->vam = $vam; // مبلغ مالیات بر ارزش افزوده
                $item->vop = $vam; //مجموع سهم مالیات بر ارزش افزوده از پرداخت
                $item->cop = $cap; //مبلغ پرداختی نقدی

                $item->cap = $cap;
                $item->insp = $insp;
                $tsstam = $adis + ($vam);
                $item->tsstam = $tsstam; //مبلغ كل كالا/خدمت

                $item->save();
            }
        }
        return [
            'failed' => $failed,
            'success' => $success,
        ];
    }

    public static function loadExcel($path)
    {


        $theArray = Excel::toArray([], $path);
        $factor = [];

        foreach ($theArray as $sheet => $row) {
            foreach ($row as $key => $items) {
                if ($key == 0) {
                    $factor[$sheet]['invoiceId'] = trim($items[27]);
                    if (!isset($items[27])) {
                        break;
                    }
                } elseif ($key == 1) {
                    $factor[$sheet]['indatim'] = trim($items[27]);
                } elseif ($key == 2) {
                    continue;
                } elseif ($key == 3) {
                    $factor[$sheet]['otherTax'] = 0;
                    $factor[$sheet]['sellerType'] = trim($items[1]);
                    $factor[$sheet]['sellerName'] = trim($items[3]);
                    $factor[$sheet]['sellerEcoNumber'] = trim($items[9]);
                    $factor[$sheet]['sellerRegisterNumber'] = trim($items[20]);
                    $factor[$sheet]['sellerNationalNumber'] = trim($items[28]);
                } elseif ($key == 4) {

                    $factor[$sheet]['sellerProvince'] = trim($items[2]);
                    $factor[$sheet]['sellerCity'] = trim($items[4]);
                    $factor[$sheet]['sellerTown'] = trim($items[9]);
                    $factor[$sheet]['sellerPostalCode'] = trim($items[20]);

                } elseif ($key == 5) {

                    $factor[$sheet]['sellerAddress'] = trim($items[2]);
                    $factor[$sheet]['sellerPhone'] = trim($items[20]);

                } elseif ($key == 6) {
                    continue;
                } elseif ($key == 7) {
                    $factor[$sheet]['buyerType'] = trim($items[1]);
                    $factor[$sheet]['buyerName'] = trim($items[3]);
                    $factor[$sheet]['buyerEcoNumber'] = trim($items[9]);
                    $factor[$sheet]['buyerRegisterNumber'] = trim($items[20]);
                    $factor[$sheet]['buyerNationalNumber'] = trim($items[28]);
                } elseif ($key == 8) {
                    $factor[$sheet]['buyerProvince'] = trim($items[2]);
                    $factor[$sheet]['buyerCity'] = trim($items[4]);
                    $factor[$sheet]['buyerTown'] = trim($items[9]);
                    $factor[$sheet]['buyerPostalCode'] = trim($items[20]);

                } elseif ($key == 9) {

                    $factor[$sheet]['buyerAddress'] = trim($items[2]);
                    $factor[$sheet]['buyerPhone'] = trim($items[20]);
                } elseif ($key == 10) {
                    $factor[$sheet]['typeInvoice'] = trim($items[1]);
                    $factor[$sheet]['typePayment'] = trim($items[3]);
                    $factor[$sheet]['typePattern'] = trim($items[5]);
                    $factor[$sheet]['typeSubject'] = trim($items[11]);
                    $factor[$sheet]['datePayment'] = trim($items[27]);


                } elseif ($key == 11) {
                    continue;
                } elseif ($key == 12) {
                    continue;
                } else {

                    if (empty(trim($items[1])) && empty(trim($items[2]))) {
                        break;
                    }

                    $factor[$sheet]['items'][] = [
                        'sstid' => trim($items[1]),
                        'sstt' => trim($items[2]),
                        'am' => trim($items[5]),
                        'mu' => trim($items[6]),
                        'fee' => trim($items[8]),

                        'dis' => trim($items[15]),
                        'cap' => trim($items[19]),
                        'insp' => trim($items[22]),
                    ];

                }
            }
        }

        return $factor;
    }


    public static function invoiceStatus($label = true)
    {
        if ($label) {
            return [

                self::STATUS_DEFAULT => '<span class="label label-default">ارسال نشده</span>',
                self::INVOICE_SENT => '<span class="label label-primary">ارسال شده</span>',
                self::INVOICE_SUCCESS => '<span class="label label-success">تایید شده</span>',
                self::INVOICE_FAILED => '<span class="label label-danger">عدم تایید سامانه</span>',
                self::INVOICE_NOTFOUND => '<span class="label label-info">پیدا نشد</span>',
                self::INVOICE_PENDING => '<span class="label label-warning">در انتظار سامانه</span>',
                self::INVOICE_IN_PROGRESS => '<span class="label label-warning">درحال پردازش</span>',
            ];
        } else {
            return [
                self::STATUS_DEFAULT => 'ارسال نشده',
                self::INVOICE_SENT => 'ارسال شده',
                self::INVOICE_SUCCESS => 'تایید شده',
                self::INVOICE_FAILED => 'عدم تایید سامانه',
                self::INVOICE_NOTFOUND => 'پیدا نشد',
                self::INVOICE_PENDING => 'در انتظار سامانه',
                self::INVOICE_IN_PROGRESS => 'درحال پردازش',
            ];
        }


    }

    public static function checkTypePattern($value)
    {

        $error = 1;
        $message = "الگوی صورتحساب معتبر نیست.";
        $default = [
            'فروش' => 1,
            'فروش ارزی' => 2,
            'صورتحساب طلا' => 3,
            'پیمانکاری' => 4,
            'قبوض' => 5,
            'بلیت هواپیما' => 6,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkTypeSubject($value)
    {

        $error = 1;
        $message = "موضوع صورتحساب معتبر نیست.";
        $default = [
            'اصلی' => self::TYPE_SUBJECT_ASLI,
            'اصلاحی' => self::TYPE_SUBJECT_ESLAHI,
            'ابطالی' => self::TYPE_SUBJECT_EBTALI,
            'برگشت از فروش' => self::TYPE_SUBJECT_BARGASHTI,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkTypePayment($value)
    {

        $error = 1;
        $message = "نوع پرداخت صورتحساب معتبر نیست.";
        $default = [
            'نقد' => 1,
            'نسیه' => 2,
            'هم نقد هم نسیه' => 3,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkTypeInvoice($value)
    {

        $error = 1;
        $message = "نوع فاکتور معتبر نیست.";
        $default = [
            'نوع اول' => 1,
            'نوع دوم' => 2,
            'نوع سوم' => 3,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkCountNumber($value, $count = 0, $count2 = 0)
    {
        $error = 0;
        $message = "";
        if (!empty($value)) {
            if ($count > 0) {

                if ($count2 > 0) {
                    if (strlen($value) != $count && strlen($value) != $count2) {
                        $error = 1;
                        $message = "باید شامل" . " " . $count . " یا " . $count2 . " " . " رقم باشد.";
                    }
                } else {
                    if (strlen($value) != $count) {
                        $error = 1;
                        $message = "باید شامل" . " " . $count . " رقم باشد.";
                    }
                }
            } else {
                if (!is_numeric($value)) {
                    $error = 1;
                    $message = "به عدد وارد شود.";
                }
            }
        }

        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];
    }

    public static function checkTypeUser($value)
    {

        $error = 1;
        $message = "نوع خریدار معتبر نیست.";
        $default = [
            'حقیقی' => 1,
            'حقوقی' => 2,
            'مشارکت مدنی' => 3,
            'اتباع غیر ایرانی' => 4,
            'مصرف کننده نهایی' => 5,
        ];


        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function checkUnitMeasurement($value)
    {

        $error = 1;
        $message = "واحد اندازه گیری معتبر نیست.";
        $measurement = [
            '1611' => 'لنگه',
            '1612' => 'عدل',
            '1613' => 'جعبه',
            '1618' => 'توپ',
            '1619' => 'ست',
            '1620' => 'دست',
            '1624' => 'کارتن',
            '1627' => 'عدد',
            '1628' => 'بسته',
            '1629' => 'پاکت',
            '1631' => 'دستگاه',
            '16118' => 'مگا وات ساعت',
            '16117' => 'نوبت',
            '16108' => 'لیوان',
            '1653' => 'واحد',
            '1632' => 'فروند',
            '16116' => 'سانتی متر مربع',
            '16115' => 'سانتی متر',
            '16114' => 'قطعه',
            '16113' => 'سال',
            '16112' => 'ماه',
            '16111' => 'دقیقه',
            '16110' => 'ثانیه',
            '1676' => 'نفر',
            '1669' => 'کیلو وات ساعت',
            '16105' => 'تن کیلومتر',
            '16104' => 'روز',
            '16103' => 'ساعت',
            '16102' => 'میلی گرم',
            '16101' => 'میلی متر',
            '16100' => 'میلی لیتر',
            '1678' => 'قیراط',
            '1652' => 'شعله',
            '1616' => 'نخ',
            '1622' => 'گرم',
            '1636' => 'جام',
            '1659' => 'چلیک',
            '1665' => 'شیت',
            '168' => 'حلب',
            '1647' => 'متر مکعب',
            '1660' => 'شانه',
            '163' => 'قالب',
            '1630' => '(رول)حلقه',
            '1656' => 'بندیل',
            '1683' => 'کپسول',
            '1650' => 'ساشه',
            '1637' => 'لیتر',
            '1694' => 'قراصه(bundle)',
            '1673' => 'قراص',
            '1668' => '(رینگ)حلقه',
            '1661' => 'دوجین',
            '1649' => 'پالت',
            '1645' => 'متر مربع',
            '1643' => 'جفت',
            '1642' => 'طاقه',
            '1641' => 'رول',
            '1640' => 'تخته',
            '1689' => 'ثوب',
            '1690' => 'نیم دوجین',
            '1635' => 'قرقره',
            '164' => 'کیلوگرم',
            '1638' => 'بطری',
            '161' => 'برگ',
            '1625' => 'سطل',
            '1654' => 'ورق',
            '1646' => 'شاخه',
            '1644' => 'قوطی',
            '1617' => 'جلد',
            '162' => 'تیوب',
            '165' => 'متر',
            '1610' => 'کلاف',
            '1615' => 'کیسه',
            '1680' => 'طغرا',
            '1639' => 'بشکه',
            '1614' => 'گالن',
            '1687' => 'فاقد بسته بندی',
            '1693' => 'کارت(master case)',
            '166' => 'صفحه',
            '1666' => 'مخزن',
            '1626' => 'تانکر',
            '1648' => 'دبه',
            '1684' => 'سبد',
            '169' => 'تن',
            '1651' => 'بانکه',
            '1633' => 'سیلندر',
            '1679' => 'فوت مربع',
        ];
        $default = array_flip($measurement);

        if (isset($default[$value])) {
            $error = 0;
            $message = "";
            $value = $default[$value];
        }
        return [
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];

    }

    public static function defaultMaliatValue()
    {
        $typePatternArray = [
            'فروش' => 1,
            'فروش ارزی' => 2,
            'صورتحساب طلا' => 3,
            'پیمانکاری' => 4,
            'قبوض' => 5,
            'بلیت هواپیما' => 6,
        ];
        $typeSubjectArray = [
            'اصلی' => self::TYPE_SUBJECT_ASLI,
            'اصلاحی' => self::TYPE_SUBJECT_ESLAHI,
            'ابطالی' => self::TYPE_SUBJECT_EBTALI,
            'برگشت از فروش' => self::TYPE_SUBJECT_BARGASHTI,
        ];
        $typePaymentArray = [
            'نقد' => 1,
            'نسیه' => 2,
            'هم نقد هم نسیه' => 3,
        ];
        $typeInvoiceArray = [
            'نوع اول' => 1,
            'نوع دوم' => 2,
            'نوع سوم' => 3,
        ];
        $userTypeArray = [
            'حقیقی' => 1,
            'حقوقی' => 2,
            'مشارکت مدنی' => 3,
            'اتباع غیر ایرانی' => 4,
            'مصرف کننده نهایی' => 5,
        ];
        $unitMeasurementArray = [
            '1611' => 'لنگه',
            '1612' => 'عدل',
            '1613' => 'جعبه',
            '1618' => 'توپ',
            '1619' => 'ست',
            '1620' => 'دست',
            '1624' => 'کارتن',
            '1627' => 'عدد',
            '1628' => 'بسته',
            '1629' => 'پاکت',
            '1631' => 'دستگاه',
            '16118' => 'مگا وات ساعت',
            '16117' => 'نوبت',
            '16108' => 'لیوان',
            '1653' => 'واحد',
            '1632' => 'فروند',
            '16116' => 'سانتی متر مربع',
            '16115' => 'سانتی متر',
            '16114' => 'قطعه',
            '16113' => 'سال',
            '16112' => 'ماه',
            '16111' => 'دقیقه',
            '16110' => 'ثانیه',
            '1676' => 'نفر',
            '1669' => 'کیلو وات ساعت',
            '16105' => 'تن کیلومتر',
            '16104' => 'روز',
            '16103' => 'ساعت',
            '16102' => 'میلی گرم',
            '16101' => 'میلی متر',
            '16100' => 'میلی لیتر',
            '1678' => 'قیراط',
            '1652' => 'شعله',
            '1616' => 'نخ',
            '1622' => 'گرم',
            '1636' => 'جام',
            '1659' => 'چلیک',
            '1665' => 'شیت',
            '168' => 'حلب',
            '1647' => 'متر مکعب',
            '1660' => 'شانه',
            '163' => 'قالب',
            '1630' => '(رول)حلقه',
            '1656' => 'بندیل',
            '1683' => 'کپسول',
            '1650' => 'ساشه',
            '1637' => 'لیتر',
            '1694' => 'قراصه(bundle)',
            '1673' => 'قراص',
            '1668' => '(رینگ)حلقه',
            '1661' => 'دوجین',
            '1649' => 'پالت',
            '1645' => 'متر مربع',
            '1643' => 'جفت',
            '1642' => 'طاقه',
            '1641' => 'رول',
            '1640' => 'تخته',
            '1689' => 'ثوب',
            '1690' => 'نیم دوجین',
            '1635' => 'قرقره',
            '164' => 'کیلوگرم',
            '1638' => 'بطری',
            '161' => 'برگ',
            '1625' => 'سطل',
            '1654' => 'ورق',
            '1646' => 'شاخه',
            '1644' => 'قوطی',
            '1617' => 'جلد',
            '162' => 'تیوب',
            '165' => 'متر',
            '1610' => 'کلاف',
            '1615' => 'کیسه',
            '1680' => 'طغرا',
            '1639' => 'بشکه',
            '1614' => 'گالن',
            '1687' => 'فاقد بسته بندی',
            '1693' => 'کارت(master case)',
            '166' => 'صفحه',
            '1666' => 'مخزن',
            '1626' => 'تانکر',
            '1648' => 'دبه',
            '1684' => 'سبد',
            '169' => 'تن',
            '1651' => 'بانکه',
            '1633' => 'سیلندر',
            '1679' => 'فوت مربع',
        ];

        return [
            'typePattern' => $typePatternArray,
            'typeSubject' => $typeSubjectArray,
            'typePayment' => $typePaymentArray,
            'typeInvoice' => $typeInvoiceArray,
            'userType' => $userTypeArray,
            'unitMeasurement' => $unitMeasurementArray,
            'ReversUnitMeasurement' => array_flip($unitMeasurementArray),
        ];
    }

    public static function maliatLabelName()
    {
        return [
            'send_to_moadian' => 'تاریخ ارسال به سامانه',
            'trn' => 'شماره فاکتور',
            'parent_id' => 'فاکتور مرجع',
            'created_at' => 'تاریخ ثبت',
            'updated_at' => 'تاریخ ویرایش',
            'indatim' => 'تاریخ صدور',
            'indatim2' => 'تاریخ صدور',
            'inty' => 'نوع فاکتور',
            'inno' => 'شماره فاکتور',
            'inp' => 'الگوی صورت حساب',
            'ins' => 'موضوع صورت حساب',
            'tins' => 'شماره اقتصادی فروشنده',
            'tob' => 'نوع خریدار',
            'bid' => 'شماره/شناسه ملی/شناسه مشاركت مدنی/كد فراگیر خریدار',
            'tinb' => 'شماره اقتصادی خریدار یا کد ملی اش',
            'bpc' => 'كد پستی خریدار',
            'tprdis' => ' مجموع مبلغ قبل از كسر تخفیف',
            'tdis' => 'مجموع تخفیفات',
            'tadis' => ' مجموع مبلغ پس از كسر تخفیف',
            'tvam' => 'مجموع مالیات بر ارزش افزوده',
            'todam' => 'مجموع سایر مالیات، عوارض و وجوه قانونی',
            'tbill' => 'مجموع صورتحساب',
            'setm' => 'روش تسویه',
            'cap' => 'مبلغ پرداختی نقدی',
            'insp' => 'مبلغ پرداختی نسیه',
            'tvop' => 'مجموع سهم مالیات بر ارزش افزوده از پرداخت',
            'dpvb' => 'عدم پرداخت مالیات بر ارزش افزوده خریدار',
            'tax17' => ' مالیات موضوع ماده ۱۷',
            //invoce Item
            'sstid' => 'شناسه كالا/خدمت',
            'sstt' => 'شرح كالا/خدمت',
            'mu' => 'واحد اندازه گیری',
            'am' => 'تعداد / مقدار',
            'fee' => 'مبلغ واحد',
            'cfee' => 'میزان ارز',
            'cut' => 'نوع ارز',
            'exr' => 'نرخ برابری ارز با ریال',
            'prdis' => 'مبلغ قبل از تخفیف',
            'dis' => 'مبلغ تخفیف',
            'adis' => 'مبلغ بعد از تخفیف',
            'vra' => 'نرخ مالیات بر ارزش افزوده',
            'vam' => 'مبلغ مالیات بر ارزش افزوده',
            'odt' => 'موضوع سایر مالیات و عوارض',
            'odr' => 'نرخ سایر مالیات و عوارض',
            'odam' => 'مبلغ سایر مالیات و عوارض',
            'olt' => 'موضوع سایر وجوه قانونی',
            'olr' => 'نرخ سایر وجوه قانونی',
            'olam' => 'مبلغ سایر وجوه قانونی',
            'consfee' => 'اجرت ساخت',
            'spro' => 'سود فروشنده',
            'bros' => 'حق العمل',
            'tcpbs' => 'جمع کل اجرتُ حق العمل و سود',
            'cop' => 'مبلغ پرداختی نقدی',
            'vop' => 'مجموع سهم مالیات بر ارزش افزوده از پرداخت',
            'bsrn' => 'شناسه یکتای ثبت قرارداد حق العملکاری',
            'tsstam' => 'مبلغ كل كالا/خدمت',
            //payment
            'iinn' => 'شماره سوئیچ پرداخت',
            'acn' => 'شماره پذیرنده فروشگاهی',
            'trmn' => 'شماره پایانه',
            'pcn' => 'شماره کارت پرداخت کننده صورت حساب',
            'pid' => 'شماره/شناسه ملی/كد فراگیر اتباع غیر ایرانی پرداخت كننده صورتحساب',
            'pdt' => 'تاریخ و زمان پرداخت صورتحساب',
            'uid' => 'uid',
            'referenceNumber' => 'referenceNumber',

        ];
    }


    public static function roundDown($x, $y, $is_multiple = true)
    {

        if (is_int($x * $y)) {
            $result = $x * $y;
        } else {
            $result = floor($x * $y);
        }

        if (!$is_multiple) {
            if (is_int($x / $y)) {
                $result = $x / $y;
            } else {
                $result = floor($x / $y);
            }
        }
        return $result;
    }

    public static function getMoadianPrivateKey($keyName)
    {
        $privateKey = file_get_contents(public_path("uploads/keys/" . $keyName));
        return $privateKey;
    }

}
