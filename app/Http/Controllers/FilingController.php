<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Data;
use App\Models\Filing;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilingController extends Controller
{
    private $pathImage = "upload/pemberkasan/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $branch_name = Branch::where("code", $request->ld)->first()->name;
            $file = $request->file('file');
            $fileName = time() . $file->hashName();
            $file->move(public_path($this->pathImage), $fileName);
            $for = 0;
            $from = 0;
            if (Auth::user()->role == 1) {
                $from = 1;
                $descrition = "Admin Bsi melakukan pemberkasan pada data cabang $branch_name";
                $for  = 2;
            } else {
                $from = 2;
                $for  = 1;
                $descrition = "Admin Eka melakukan pemberkasan pada data cabang $branch_name";
            }
            $filing = Filing::create([
                'from' => $from,
                'file' => $fileName,
                'ld' => $request->ld,
                'notification_id' => 0
            ]);
            $notif = Notification::create([
                'for' => $for,
                'from' => $from,
                'description' => $descrition,
                'status' => 0,
                'filing_id' => $filing->id,
            ]);
            $filing->update(['notification_id' => $notif->id]);
            return response()->json([
                'status' => true,
                'message' => [
                    'head' => 'Sukses',
                    'body' => 'Pemberkasan berhasil',
                    'link' => asset('upload/pemberkasan/' . $filing->file)
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => [
                    'head' => 'Gagal',
                    'body' => $th->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Filing::where('ld', $id)->get();
        $reconcile_datas = Data::where("branch_code", $id)->where("reconciled_data_id", "!=", null)->get();
        foreach ($data as $key => $value) {
            $value->file = asset('upload/pemberkasan/' . $value->file);
        }

        return response()->json(
            ['data'=>$data, 'isReconciled'=>count($reconcile_datas)>0],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Notification::find($id)->update(['status' => 1]);
        return response()->json([], 200);
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
        //
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
}
