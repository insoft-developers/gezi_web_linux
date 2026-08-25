<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TryoutReportExport implements FromView
{
    protected $utama;
    protected $tryout;
    
    function __construct($utama, $tryout) {
        $this->utama = $utama;
        $this->tryout = $tryout;
    }
    public function view(): View
    {
        $view = '';
        $utama = $this->utama;
        $tryout = $this->tryout;
        return view('tryout.laporan_export', compact('utama', 'tryout','view'));
    }
}
