<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;

use App\Models\Address;
use App\Models\Main;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminDashboardController extends MainController
{
    public function dashboard()
    {

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
