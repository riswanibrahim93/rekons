<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Project;
use App\Models\SiberData;
use Maatwebsite\Excel\Concerns\ToModel;

class ProjectsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new SiberData([
            'name'     => $row['name'],
            'introduction'    => $row['introduction'],
            'location'    => $row['location'],
            'cost'    => $row['cost']
        ]);
    }
}
