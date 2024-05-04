<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignExportClass implements FromCollection, WithHeadings
{
    function __construct($id) {
        $this->data = $id;
    }

    public function headings(): array {

        return [
            "DNI",
            "Mobile No",
            "Status",
            "DTMF",
            "Call Duration",
            ];

    }

    public function collection()
    {
        return collect($this->data);
    }
}
