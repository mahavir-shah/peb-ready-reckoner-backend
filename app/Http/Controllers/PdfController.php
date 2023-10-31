<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function export_pdf(){
        $filePath = public_path('projectestimation/Get_Started_With_Smallpdf.pdf');
        return response()->download($filePath);
    }
}
