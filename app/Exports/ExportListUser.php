<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportListUser implements FromView
{
    protected $data;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function view(): View
    {

        return view('exports.list_user', [
            'users' => $this->data
        ]);
    }
}
