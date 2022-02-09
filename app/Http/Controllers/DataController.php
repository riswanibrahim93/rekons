<?php

namespace App\Http\Controllers;

use App\Imports\ImportData;
use App\Models\Branch;
use App\Models\Data;
use App\Models\ReconciledData;
use App\Models\Bava;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ekaIndex(Request $request){
        $query = "";
        if ($request->keyword) {
            $query = Data::where("owner", 2)
            ->where(function ($q) use ($request) {
                $keyword = $request->keyword;
                $q
                    ->where('full_name', 'LIKE', "%" . $keyword . "%")
                    ->orWhere('branch_name', 'LIKE', "%" . $keyword . "%")
                    ->orWhere('product', 'LIKE', "%" . $keyword . "%")
                    ->orWhere('ld', 'LIKE', "%" . $keyword . "%")
                    ->orWhere('date', 'LIKE', "%" . $keyword . "%");
            });
        } else {
            $query = Data::where("owner", 2);
        }
        $datas = $query->paginate(5);
        if ($request->ajax()) {
            return view('pages.data.eka-pagination', compact('datas'))->render();
        }
        return view('pages.data.index-eka', compact('datas'));
    }
    public function index(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d') . '%';
        $query = "";
        // $query_eka = Data::query();
        if ($request->keyword) {
            $query = Data::where("owner", 1)
            ->where(function ($q) use ($request) {
                $keyword = $request->keyword;
                $q
                    ->where('full_name', 'LIKE', "%" . $keyword . "%")
                    ->orWhere('branch_name', 'LIKE', "%" . $keyword . "%")
                    ->orWhere('product', 'LIKE', "%" . $keyword . "%")
                    ->orWhere('ld', 'LIKE', "%" . $keyword . "%")
                ->orWhere('date', 'LIKE', "%" . $keyword . "%");
            });
        }else {
             $query = Data::where("owner", 1);
        }

        $bsi_data = $query->paginate(5);
        if ($request->ajax()) {
            return view('pages.data.bsi-pagination', compact('bsi_data'))->render();
        }
        return view('pages.data.index', compact('bsi_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d') . '%';

        $bsi_data = Data::where('owner', 1)->where('created_at', 'like', $today)->get();
        $eka_data = Data::where('owner', 2)->where('created_at', 'like', $today)->get();

        if (count($bsi_data) < 1 || count($eka_data) < 1) {
            return response()->json([
                'status' => false,
                'text' => "Silahkan cek data anda terlebih dahulu."
            ], 500);
        }
        $result = [];

        for ($i = 0; $i < count($eka_data); $i++) {
            $checker = [];
            $temp_data = [];
            for ($j = 0; $j < count($bsi_data); $j++) {
                if ($eka_data[$i]->ld == $bsi_data[$j]->ld) {
                    array_push($checker, true);
                    $stat = 0;
                    $description = '';
                    $branch_condition = $eka_data[$i]->branch_code == $bsi_data[$j]->branch_code;
                    $payment_stat_condition = $eka_data[$i]->payment_status == $bsi_data[$j]->payment_status;
                    $product_condition = $eka_data[$i]->product_code == $bsi_data[$j]->product_code;
                    if ($branch_condition && $payment_stat_condition && $product_condition) {
                        $description = 'Valid';
                        $stat = 1;
                    }else{
                        $stat = 0;
                        $description = $description .(strlen($description)>0?", ":"") .(!$branch_condition?"Kode cabang":"");
                        $description = $description .(strlen($description)>0?", ":"") .(!$payment_stat_condition ? "Status pembiayaan" : "");
                        $description = $description .(strlen($description)>0?", ":"") .(!$product_condition ? "Produk" : "");
                    }
                    array_push($result, [
                        'data_id' => $eka_data[$i]->id,
                        'periode' => $waktu,
                        'bsi_id' => $bsi_data[$i]->id,
                        'atr'=> $bsi_data[$i]->atr,
                        'status' => $stat,
                        'description' => $description
                    ]);
                } else {
                    array_push($checker, false);
                }
            }
            if (!in_array(true, $checker)) {
                array_push($result, [
                    'data_id' => $eka_data[$i]->id,
                    'periode' => $waktu,
                    'bsi_id' => $bsi_data[$i]->id,
                    'atr' => 0,
                    'status' => 0,
                    'description' => 'Data tidak ada'
                ]);
            }
        }

        $unique_result = array_unique($result);
        foreach ($unique_result as $key => $value) {
            $created_recon =  ReconciledData::create($value);
            Data::find($value['data_id'])->update(['reconciled_data_id' => $created_recon->id]);
        }
        $data = ReconciledData::where('created_at', 'like', $today)->get();
        $returnHTML = view('pages.rekons.pagination', compact('data'))->render();
        return  response()->json(array('success' => true, 'html' => $returnHTML));
        // dd($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)
            ->toDateTimeString();

        $end_date = Carbon::parse($request->end_date)
            ->toDateTimeString();
        $data = Data::whereBetween('date', [$start_date, $end_date])->where('reconciled_data_id', '!=', null)->get();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $start_date = 0;
        $end_date = 0;
        if (!$request->start_date && !$request->end_date) {
            $start_date = Carbon::now()->startOfDay()->toDateTimeString();
            $end_date = Carbon::now()->endOfDay()->toDateTimeString();
        } else if ($request->start_date && !$request->end_date) {
            $start_date = Carbon::parse($request->start_date)->startOfDay()->toDateTimeString();
            $data = Data::where('date', '>=', $start_date)->where('reconciled_data_id', '!=', null)->get();
            return response()->json($data, 200);
        } else if (!$request->start_date && $request->end_date) {
            $end_date = Carbon::parse($request->end_date)->endOfDay()->toDateTimeString();
            $data = Data::where('date', '<=', $end_date)->where('reconciled_data_id', '!=', null)->get();
            return response()->json($data, 200);
        } else {
            $start_date = Carbon::parse($request->start_date)->startOfDay()
                ->toDateTimeString();

            $end_date = Carbon::parse($request->end_date)->endOfDay()
                ->toDateTimeString();
        }
        $bsi_data = Data::whereBetween('date', [$start_date, $end_date])->where('owner', 1)->get();
        $eka_data = Data::whereBetween('date', [$start_date, $end_date])->where('owner', 2)->get();
        $result = [];

        for ($i = 0; $i < count($eka_data); $i++) {
            $checker = [];
            $temp_data = [];
            for ($j = 0; $j < count($bsi_data); $j++) {
                if ($eka_data[$i]->ld == $bsi_data[$j]->ld) {
                    array_push($checker, true);
                    $stat = 0;
                    $description = '';
                    if ($eka_data[$i]->atr != $bsi_data[$j]->atr) {
                        $stat = 1;
                        $description = $description . "No Atribusi";
                    } elseif ($eka_data[$i]->branch_code != $bsi_data[$j]->branch_code) {
                        $description = $description . "Kode cabang";
                        $stat = 2;
                    } elseif ($eka_data[$i]->product != $bsi_data[$j]->product) {
                        $description = $description . "produk";
                        $stat = 2;
                    } elseif ($eka_data[$i]->plafond != $bsi_data[$j]->plafond) {
                        $description = $description . "plafond";
                        $stat = 2;
                    } elseif ($eka_data[$i]->outstanding != $bsi_data[$j]->outstanding) {
                        $description = $description . "Beda fasilitas";
                        $stat = 2;
                    } else {
                        $description = 'valid';
                        $stat = 3;
                    }
                    array_push($result, [
                        'data_id' => $eka_data[$i]->id,
                        'status' => $stat,
                        'description' => $description
                    ]);
                } else {
                    array_push($checker, false);
                }
            }

            if (!in_array(true, $checker)) {
                array_push($result, [
                    'data_id' => $eka_data[$i]->id,
                    'status' => 0,
                    'description' => 'Data tidak ada'
                ]);
            }
        }
        dd($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $prevData = ReconciledData::find($id);
            if ($prevData) {
               $prevData->delete();
                Data::where('reconciled_data_id', $id)->update(['reconciled_data_id'=>null]);
                # code...
            }
            return response()->json(
                [
                    'status'=>true, 
                'body'=>[
                'messege'=>'berhasil'
            ]],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'body' => [
                    'messege' => $th->getMessage()
                ]
            ],500);
        }
        
    }
    public function importData()
    {
            try {
                $result =  Excel::import(new ImportData, request()->file('file'));
            } catch(\Throwable $th) {
            return back()->with('error', $th->getMessage());
            }
         
            return back()->with('success', 'Data berhasil diupload!');
      
    }
    public function process(Request $request)
    {

        // $query = DB::table('reconciled_data')
        //  ->leftJoin('data', 'data.reconciled_data_id', '=', 'reconciled_data.id') 
        //  ->select('data.branch_name', DB::raw('SUM(data.plafond) AS biaya'), DB::raw('COUNT(*) AS noa'))
        //  ->groupBy('branch_name');

        // $query = ReconciledData::with('data')->get()->groupBy('data.branch_name');




        $query = ReconciledData::query();
        $query = $query->leftJoin('data', 'data.reconciled_data_id', '=', 'reconciled_data.id') 
         ->select('data.branch_name', DB::raw('SUM(data.plafond) AS biaya'), DB::raw('COUNT(*) AS noa'))
         ->groupBy('branch_name');

         $query->whereHas("data", function ($q) use ($request) {
            $keyword = $request->keyword;

            if ($keyword == "pemberkasan" || $keyword == "invalid") {
                $keyword = $keyword == "pemberkasan" ? 1 : 0;
                // dd($keyword);
            }
            $q->where('full_name', 'LIKE', "%$keyword%")
            ->orWhere('ld', 'LIKE', "%$keyword%")
            ->orWhere('branch_name', 'LIKE', "%$keyword%")
            ->orWhere('product', 'LIKE', "%$keyword%")
            ->orWhere('atr', 'LIKE', "%$keyword%")
            // ->orWhere('payment_status', 'LIKE', "%$keyword%")
            ->orWhere('outstanding', 'LIKE', "%$keyword%");
        });


        // $query->Data()->groupBy('branch_name')->get();

        // $query->groupBy('branch_name')

        // $query = DB::table('reconciled_data')
        //  ->leftJoin('data', 'data.reconciled_data_id', '=', 'reconciled_data.id') 
        //  ->select('data.branch_name', DB::raw('SUM(data.plafond) AS biaya'), DB::raw('COUNT(*) AS noa'))
        //  ->groupBy('branch_name');
        // dd($query);

        $periode = ReconciledData::select('periode')->first();

        $notif = "";
        $branches = Branch::get();

        $data = $query->paginate(5);
        // dd($data);
        if ($request->branch) {
            $notif= $request->branch;
        }
        if ($request->ajax()) {
           return view('pages.rekons.pagination', compact('data', 'branches','notif', 'periode'))->render();
        }
        return view('pages.rekons.index', compact('data', 'branches','notif', 'periode'));
    }
    public function checkData(Request $request)
    {
        $start_date = 0;
        $end_date = 0;
        if (!$request->start_date && !$request->end_date) {
            $start_date = Carbon::now()->startOfDay()->toDateTimeString();
            $end_date = Carbon::now()->endOfDay()->toDateTimeString();
        } else if ($request->start_date && !$request->end_date) {
            $start_date = Carbon::parse($request->start_date)->startOfDay()->toDateTimeString();
            $data = Data::where('date', '>=' ,$start_date)->where('reconciled_data_id', '!=', null)->get();
            return response()->json($data, 200);
        } else if (!$request->start_date && $request->end_date) {
            $end_date = Carbon::parse($request->end_date)->endOfDay()->toDateTimeString();
            $data = Data::where('date', '<=', $end_date)->where('reconciled_data_id', '!=', null)->get();
            return response()->json($data, 200);
        } else {
            $start_date = Carbon::parse($request->start_date)->startOfDay()
                ->toDateTimeString();

            $end_date = Carbon::parse($request->end_date)->endOfDay()
                ->toDateTimeString();
        }
        $data = Data::whereBetween('date', [$start_date, $end_date])->where('reconciled_data_id', '!=', null)->get();
        return response()->json($data, 200);
    }

    private function  checkTempData(array $array, $value)
    {
        for ($i=0; $i < count($array); $i++) {
           if ($array[$i]["data_id"]==$value) {
              return true;
           }
        }
        return false;
    }

    public function processRecons(Request $request)
    {

        $start_date = 0;
        $end_date = 0;
        $bsi_data = [];
        $eka_data = [];
        if (!$request->start_date && !$request->end_date) {
            $start_date = Carbon::now()->startOfDay()->toDateTimeString();
            $end_date = Carbon::now()->endOfDay()->toDateTimeString();
        } else if ($request->start_date && !$request->end_date) {
            $start_date = Carbon::parse($request->start_date)->startOfDay()->toDateTimeString();
            // $data = Data::where('date', '>=', $start_date)->get();
            $bsi_data = Data::where('date', '>=', $start_date)->where('owner', 1)->get();
            $eka_data = Data::where('date', '>=', $start_date)->where('owner', 2)->get();
            // return response()->json($data, 200);
        } else if (!$request->start_date && $request->end_date) {
            $end_date = Carbon::parse($request->end_date)->endOfDay()->toDateTimeString();
            $data = Data::where('date', '<=', $end_date)->get();
            $bsi_data = Data::where('date', '<=', $end_date)->where('owner', 1)->get();
            $eka_data = Data::where('date', '<=', $end_date)->where('owner', 2)->get();
            // return response()->json($data, 200);
        } else {
            $start_date = Carbon::parse($request->start_date)->startOfDay()
                ->toDateTimeString();

            $end_date = Carbon::parse($request->end_date)->endOfDay()
                ->toDateTimeString();
                $bsi_data = Data::whereBetween('date', [$start_date, $end_date])->where('owner', 1)->get();
                $eka_data = Data::whereBetween('date', [$start_date, $end_date])->where('owner', 2)->get();
        }
        $result = [];

        $awal = $request->start_date;
        $arr_awal = explode("-",$awal);
        $akhir = $request->end_date;
        $arr_akhir = explode("-",$akhir);
        $hari_akhir = $arr_akhir[2];
        $bulan_akhir = $arr_akhir[1];
        $tahun_akhir = $arr_akhir[0][2].$arr_akhir[0][3];
        $waktu = $arr_awal[2].'-'.$hari_akhir.$bulan_akhir.$tahun_akhir;

     


        for ($i = 0; $i < count($eka_data); $i++) {
            $checker = [];
            $temp_data = [];
            for ($j = 0; $j < count($bsi_data); $j++) {
                if ($eka_data[$i]->ld == $bsi_data[$j]->ld) {
                    array_push($checker, true);
                    $stat = 0;
                    $description = '';
                    $branch_condition = $eka_data[$i]->branch_code == $bsi_data[$j]->branch_code;
                    $payment_stat_condition = $eka_data[$i]->payment_status == $bsi_data[$j]->payment_status;
                    $product_condition = $eka_data[$i]->product_code == $bsi_data[$j]->product_code;
                    if ($branch_condition && $payment_stat_condition && $product_condition) {
                        $description = 'Valid';
                        $stat = 1;
                    } else {
                        $stat = 0;
                        $description = $description . (strlen($description) > 0 ? ", " : "") . (!$branch_condition ? "Kode cabang" : "");
                        $description = $description . (strlen($description) > 0 ? ", " : "") . (!$payment_stat_condition ? "Status pembiayaan" : "");
                        $description = $description . (strlen($description) > 0 ? ", " : "") . (!$product_condition ? "Produk" : "");
                    }
                    array_push($result, [
                        'data_id' => $eka_data[$i]->id,
                        'periode' => $waktu,
                        'bsi_id' => $bsi_data[$i]->id,
                        'atr' => $bsi_data[$i]->atr,
                        'status' => $stat,
                        'description' => $description
                    ]);
                } else {
                    array_push($checker, false);
                }
            }
            if (!in_array(true, $checker)) {
                array_push($result, [
                    'data_id' => $eka_data[$i]->id,
                    'periode' => $waktu,
                    'bsi_id' => $bsi_data[$i]->id,
                    'atr' => 0,
                    'status' => 0,
                    'description' => 'Data tidak ada'
                ]);
            }
        }

        $unique_result = array_unique($result, SORT_REGULAR);
        foreach ($unique_result as $key => $value) {
            $created_recon =  ReconciledData::create($value);
            Data::find($value['data_id'])->update(['reconciled_data_id' => $created_recon->id]);
        }
        $data = [];
        // $returnHTML = view('pages.rekons.pagination', compact('data'))->render();
        return  response()->json([
               $bsi_data,
        $eka_data,
        $result
        ],200);
        // dd($result);
    }

    public function processReconsDetail(Request $request)
    {
        $query = ReconciledData::query();
        $query->whereHas("data", function ($q) use ($request) {
            $keyword = $request->keyword;

            if ($keyword == "pemberkasan" || $keyword == "invalid") {
                $keyword = $keyword == "pemberkasan" ? 1 : 0;
                // dd($keyword);
            }
            $q->where('full_name', 'LIKE', "%$keyword%")
            ->orWhere('ld', 'LIKE', "%$keyword%")
            ->orWhere('branch_name', 'LIKE', "%$keyword%")
            ->orWhere('product', 'LIKE', "%$keyword%")
            ->orWhere('atr', 'LIKE', "%$keyword%")
            // ->orWhere('payment_status', 'LIKE', "%$keyword%")
            ->orWhere('outstanding', 'LIKE', "%$keyword%");
        });

        $query->whereHas("data", function ($q) use ($request) {
            $q->where('branch_name', $request->branch);
        });

        $data = $query->get();
        $branch_name = $request->branch;
        $branches = Branch::get();
        $notif = "";
        // dd($data);
        return view('pages.rekons.detail', compact('data','branch_name','branches','notif'));
    }

    public function uploadBava(Request $request)
    {
        $bava = $request->file('file');
        $bava_name = uniqid();
        $bava_name = $bava_name.'.'.$bava->getClientOriginalExtension();
        // dd($bava_name);
        $branch_code = Branch::select('code')->where('name', $request->branch_name)->get()->toArray();
        $branch_code = $branch_code[0]['code'];
        $bava->move('pdf-bava', $bava_name);


        $bava = new Bava;
        $bava->branch_code = $branch_code;
        $bava->file = $bava_name;
        $bava->save();

        return redirect('process-recons')->with('status', 'Upload File Bava Berhasil');
    }

    public function bava(Request $request){
        $branch_code = Branch::select('code')->where('name', $request->branch)->get()->toArray();
        $branch_code = $branch_code[0]['code'];

        $bava = Bava::where('branch_code', $branch_code)->get();
        $branch_name = $request->branch;
        // dd($bava);
        return view('pages.rekons.detail-bava', compact('bava', 'branch_name'));
    }

    public function validasiSelected(Request $request)
    {
        // dd('berhasil');
        // $ids = [57,58];
        $ids = $request->ids;
        $data = ReconciledData::whereIn('id', $ids)
            ->update([
                'status' => 1,
                'description' => 'Valid'
            ]);
        // dd($data);  
        // $status = $ids[0];
        return  response()->json($data,200);
    }
    public function tolakSelected(Request $request)
    {
        // dd('berhasil');
        // $ids = [57,58];
        $ids = $request->ids;
        $data = ReconciledData::whereIn('id', $ids)
            ->update([
                'status' => 0,
                'description' => 'Ditolak'
            ]);
        // dd($data);  
        // $status = $ids[0];
        return  response()->json($data,200);
    }

    public function detailCabang(Request $request)
    {
        $query = ReconciledData::query();
        $query->with('data')->whereHas("data", function ($q) use ($request) {
            $q->where('branch_name', $request->branch_name);
        });


        $data = $query->get();
        $branch_name = $request->branch_name;
        $branches = Branch::get();
        $notif = "";
        // dd($data);
        return  response()->json([$data, $branch_name],200);
        // return view('pages.rekons.detail', compact('data','branch_name','branches','notif'));
    }
}
