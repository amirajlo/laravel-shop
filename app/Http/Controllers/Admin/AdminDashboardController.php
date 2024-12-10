<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;

use App\Models\Address;
use App\Models\Main;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminDashboardController extends MainController
{
    public function dashboard()
    {
        if (false) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            ini_set('max_execution_time', 180 * 10); //3 minutes






            foreach ($payments as $key => $model) {

                 $order_id=$model['invoicenumber'];
                if(empty($model['invoicenumber'])){
                    $order_id=null;
                }

                $payment_date=$model['transactionDate'];
                if(empty($model['transactionDate'])){
                    $payment_date=null;
                }

                $newModel = [
                    'id' => $model['id'],
                    'amount' => trim($model['amount']),
                    'payment_date' =>$payment_date,
                    'order_id' => $order_id,
                    'reference_id' => trim($model['transactionreferenceid']),
                    'reference_number' => trim($model['referenceNumber']),
                    'trace_number' => trim($model['traceNumber']),
                    'status' => trim($model['status']),
                    'messages' => trim($model['description']),
                    'url' => trim($model['url_id']),



                    'created_at' => date('Y-m-d H:i:s', (int)$model['created_at']),
                    'updated_at' => date('Y-m-d H:i:s', (int)$model['updated_at']),
                ];

                DB::table('payments')->insert($newModel);

            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        }
        return view('admin.dashboard');
    }


    public function getAddress($id)
    {
        $addresses = Address::where(['user_id' => $id, 'is_deleted' => Main::STATUS_DISABLED])->get();
        return response()->json($addresses);
    }

    /**
     * Show the application dataAjax.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax()
    {
        $data = [];
        if (isset($_GET['q'])) {
            $q = $_GET['q'];
            if ($_GET['table'] == 'users') {
                $data = DB::table('users')
                    ->select("id", "first_name", 'last_name', 'username')
                    ->where('last_name', 'LIKE', "%$q%")
                    ->get();
            } else {
                $data = DB::table($_GET['table'])
                    ->select("id", "title")
                    ->where('title', 'LIKE', "%$q%")
                    ->get();
            }

        }


        return response()->json($data);
    }
}
