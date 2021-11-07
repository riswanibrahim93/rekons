<?php

namespace App\Imports;

use App\Models\Data;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportData implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use  SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Data([
            'ld'     => $row['noloan'],
            'full_name'    => $row['namalengkap'],
            'branch_code'    => $row['kodecabangbaru'],
            'branch_name'    => $row['nama_cabang'],
            'product'    => $row['produk'],
            'outstanding'    => $row['outstanding'],
            'plafond'    => $row['plafond'],
            'date'    => $row['tgllpencairan'],
            'atr'    => Auth::user()->role==2?null:$row['atribus'],
            'payment_status'=>$row['keterangan_lengkap'],
            'product_code'=>$row['kode_produk'],
            'owner'=> Auth::user()->role
        ]);
    }
    public function rules():array{
        return [
            '1' =>
           [ 'required', 
            Rule::unique('data')->where('ld', '1')
                ->where('role', Auth::user()->role)]
        ];
    }
}
