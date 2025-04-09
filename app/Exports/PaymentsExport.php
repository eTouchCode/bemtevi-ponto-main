<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{

    private $collection;
    private $header;

    public function __construct($collection, $header)
    {
        $this->collection = $collection;
        $this->header = $header;
    }

    public function headings(): array
    {
        return $this->header;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;
    }
}
