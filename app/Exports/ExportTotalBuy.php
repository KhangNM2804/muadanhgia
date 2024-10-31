<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportTotalBuy implements FromView
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

        return view('exports.buys', [
            'users' => $this->data
        ]);
    }
}
