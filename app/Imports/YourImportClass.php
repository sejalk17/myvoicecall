<?php 

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class YourImportClass implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Extract only the 'number_column'
        $filteredRows = $rows->map(function ($row) {
            return [
                'number_column' => $row['number_column'],
                // Add other columns as needed
            ];
        });

        return $filteredRows;
    }
}
