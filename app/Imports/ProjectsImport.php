<?php

namespace App\Imports;

use App\Models\Data;
// use App\Models\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;

class ProjectsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Data([
            'name'     => $row['name'],
            'introduction'    => $row['introduction'],
            'location'    => $row['location'],
            'cost'    => $row['cost']
        ]);
    }
}
