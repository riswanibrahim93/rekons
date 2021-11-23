<?php

namespace App\Http\Controllers;

use App\Imports\ImportData;
use App\Models\Branch;
use App\Models\Data;
use App\Models\ReconciledData;
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
        $query = Data::query();
        $query->when('keyword', function ($q) use ($request) {
            $keyword = $request->keyword;
            $q->where('full_name', 'LIKE', "%" . $keyword . "%")
                ->orWhere('branch_name', 'LIKE', "%" . $keyword . "%")
                ->orWhere('product', 'LIKE', "%" . $keyword . "%")
                ->orWhere('ld', 'LIKE', "%" . $keyword . "%")
                ->orWhere('date', 'LIKE', "%" . $keyword . "%");
        });
        $datas = $query->paginate(5);
        // dd(['bsi'=> $bsi_data, 'eka'=>$eka_data]);
        // if ($request->ajax()) {
        // }
        return view('pages.data.index-eka', compact('datas'));
    }
    public function index(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d') . '%';
        $query = Data::query();
        // $query_eka = Data::query();
        
        $query->when('keyword', function ($q) use ($request) {
            $keyword = $request->keyword;
            $q->where('full_name', 'LIKE', "%" . $keyword . "%")
                ->orWhere('branch_name', 'LIKE', "%" . $keyword . "%")
                ->orWhere('product', 'LIKE', "%" . $keyword . "%")
                ->orWhere('ld', 'LIKE', "%" . $keyword . "%")
            ->orWhere('date', 'LIKE', "%" . $keyword . "%");
        });

        // $query_eka->when('keyword', function ($q) use ($request) {
        //     $keyword = $request->keyword;
        //     $q->where('full_name', 'LIKE', "%" . $keyword . "%")
        //         ->orWhere('branch_name', 'LIKE', "%" . $keyword . "%")
        //         ->orWhere('product', 'LIKE', "%" . $keyword . "%")
        //         ->orWhere('ld', 'LIKE', "%" . $keyword . "%")
        //         ->orWhere('date', 'LIKE', "%" . $keyword . "%");
        // });
        $bsi_data = $query->paginate(5);
        // $eka_data = $query_eka->paginate(5);
        // dd(['bsi'=> $bsi_data, 'eka'=>$eka_data]);
        if ($request->ajax()) {
            return view('pages.data.index', compact('bsi_data', 'eka_data'));
        }
        return view('pages.data.index', compact('bsi_data', 'eka_data'));
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
            
            ReconciledData::where('data_id', $id)->delete();
            Data::where('id', $id)->update(['reconciled_data_id'=>null]);
            return response()->json([],200);
        } catch (\Throwable $th) {
            return response()->json([],500);
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

        $notif = "";
        $branches = Branch::all();
        $data = $query->OrderBy('created_at','desc')->paginate(5);
        if ($request->branch) {
            $notif= $request->branch;
        }
        if ($request->ajax()) {
           return view('pages.rekons.pagination', compact('data', 'branches','notif'))->render();
        }
        return view('pages.rekons.index', compact('data', 'branches','notif'));
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
        $data = [];
        // $returnHTML = view('pages.rekons.pagination', compact('data'))->render();
        return  response()->json([
               $bsi_data,
        $eka_data,
        $result
        ],200);
        // dd($result);
    }
}
