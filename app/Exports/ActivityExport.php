<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Check;

class ActivityExport implements FromView
{
    public function view(): View
    {
        return view('exports.activity', [
            'checks' => Check::orderBy('created_at', 'desc')->get()
        ]);
    }
}
