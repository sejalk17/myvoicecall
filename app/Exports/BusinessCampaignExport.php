<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BusinessCampaignExport implements FromCollection, WithHeadings
{
    function __construct($id) {
        $this->data = $id;
    }

    public function headings(): array {

        return [
            "Name",
            "Mobile No",
            "Rcord voice",
            "Agent Connected Status",
            "Customer Connected Status",
            "Lead Type",
            "Lead Description",
            "Disposition",
            "Remarks",
            "Followups",
            ];

    }

    public function collection()
    {
        return collect($this->data);
    }
}
