<?php

namespace App\Exports;

use App\Models\ReconciledData;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReconciledDataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReconciledData::all();
    }
}
