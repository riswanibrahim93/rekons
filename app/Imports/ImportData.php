<?php

namespace App\Imports;

use App\Models\Data;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportData implements ToModel, WithHeadingRow
// SkipsOnFailure
{
    // use  SkipsErrors, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $prevData = Data::where('ld', $row['noloan'])->where('owner' , Auth::user()->role)->first();
        if($prevData) {
            // throw new \Exception("Data dengan ld: ".$row["noloan"]."sudah ada!");
            $prevData->update([
                'ld'     => $row['noloan'],
                'full_name'    => $row['namalengkap'],
                'branch_code'    => $row['kodecabangbaru'],
                'branch_name'    => $row['nama_cabang'],
                'product'    => $row['produk'],
                'outstanding'    => $row['outstanding'],
                'plafond'    => $row['plafond'],
                'date'    => $row['tgllpencairan'],
                'atr'    => Auth::user()->role == 2 ? null : $row['atribus'],
                'payment_status' => $row['keterangan_lengkap'],
                'product_code' => $row['kode_produk'],
                'owner' => Auth::user()->role
            ]);
            return null;
        }
        return new Data([
            'ld'     => $row['noloan'],
            'full_name'    => $row['namalengkap'],
            'branch_code'    => $row['kodecabangbaru'],
            'branch_name'    => $row['nama_cabang'],
            'product'    => $row['produk'],
            'outstanding'    => $row['outstanding'],
            'plafond'    => $row['plafond'],
            'date'    => $row['tgllpencairan'],
            'atr'    => Auth::user()->role == 2 ? null : $row['atribus'],
            'payment_status' => $row['keterangan_lengkap'],
            'product_code' => $row['kode_produk'],
            'owner' => Auth::user()->role
        ]);
    }
}
