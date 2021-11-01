<?php

namespace App\Http\Controllers;

use App\Imports\ImportData;
use App\Models\Data;
use App\Models\ReconciledData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d') . '%';
        // $role = Auth::user()->role;
        $bsi_data = [];
        $eka_data = [];
        $bsi_data = Data::where('owner', 1)->where('created_at', 'like', $today)->get();
        $eka_data = Data::where('owner', 2)->where('created_at', 'like', $today)->get();
        return view('pages.data.index', compact('bsi_data', 'eka_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        foreach ($result as $key => $value) {
            ReconciledData::create($value);
        }
        $data = ReconciledData::paginate(10);
        $returnHTML= view('pages.rekons.pagination', compact('data'))->render();
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
    public function show($id)
    {
        //
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
        $today = Carbon::now()->format('Y-m-d') . '%';

        $bsi_data = Data::where('owner', 1)->where('created_at', 'like', $today)->get();
        $eka_data = Data::where('owner', 2)->where('created_at', 'like', $today)->get();

        if (count($bsi_data) < 1 || count($eka_data) < 1) {
            return response()->json([
                'status' => false,
                'text' => "Silahkan cek data anda terlebih dahulu."
            ],500);
        }
        $result = [];

        for ($i=0; $i < count($eka_data); $i++) {
            $checker = [];
            $temp_data = [];
            for ($j = 0; $j < count($bsi_data) ; $j++) { 
                if ($eka_data[$i]->ld == $bsi_data[$j]->ld) {
                    array_push($checker, true);
                    $stat = 0;
                    $description = '';
                    if ($eka_data[$i]->atr != $bsi_data[$j]->atr) {
                        $stat = 1;
                        $description = $description . "No Atribusi";
                    }elseif($eka_data[$i]->branch_code != $bsi_data[$j]->branch_code){
                        $description = $description . "Kode cabang";
                        $stat= 2;
                    }elseif($eka_data[$i]->product != $bsi_data[$j]->product){
                        $description = $description . "produk";
                        $stat = 2;
                        
                    }elseif ($eka_data[$i]->plafond != $bsi_data[$j]->plafond) {
                        $description = $description . "plafond";
                        $stat = 2;

                    }elseif ($eka_data[$i]->outstanding != $bsi_data[$j]->outstanding) {
                        $description = $description . "Beda fasilitas";
                        $stat = 2;
                    }else{
                        $description = 'valid';
                        $stat = 3;
                    }
                    array_push($result, [
                        'data_id' => $eka_data[$i]->id,
                        'status'=> $stat,
                        'description'=>$description
                    ]);
                }else{
                    array_push($checker, false);
                }
            }

            if(!in_array(true, $checker)){
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
        //
    }
    public function importData()
    {
        // $excel = Excel::class;
        try {
            $result =  Excel::import(new ImportData, request()->file('file'));
            //    dd($result);
            return back()->with('success', 'Data berhasil diupload!');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return back()->with('error', 'Data gagal diupload!');
        }
        # code...
    }
    public function process()
    {
        // $excel = Excel::class;
        $today = Carbon::now()->format('Y-m-d') . '%';
        $data = ReconciledData::where('created_at', 'like', $today)->paginate(10);
        return view('pages.rekons.index', compact('data'));
        // try {
        //     $result =  Excel::import(new ImportData, request()->file('file'));
        //     //    dd($result);
        //     return back()->with('success', 'Data berhasil diupload!');
        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        //     return back()->with('error', 'Data gagal diupload!');
        // }
        # code...
    }
}
