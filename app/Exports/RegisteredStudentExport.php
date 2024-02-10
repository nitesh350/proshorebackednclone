<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class RegisteredStudentExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**c
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data)->map(function ($row) {
            return is_array($row) ? $row : (array) $row;
        });
    }
}
