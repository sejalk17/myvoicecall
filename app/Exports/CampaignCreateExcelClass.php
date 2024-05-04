<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignCreateExcelClass implements FromCollection
{
    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        // Optional: Define headings for the Excel file
        return ['msisdn'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }
}
