<?php 

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class YourImportClassModal implements ToModel
{
    public function model(array $row)
    {
        return $row;
    }
}
