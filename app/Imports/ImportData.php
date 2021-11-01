<?php

namespace App\Imports;

use App\Models\Data;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportData implements ToModel, WithHeadingRow
{
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
            'product'    => $row['produk'],
            'outstanding'    => $row['outstanding'],
            'plafond'    => $row['plafond'],
            'date'    => $row['tgllpencairan'],
            'atr'    => $row['atribus'],
            'owner'=> Auth::user()->role

        ]);
    }
}
