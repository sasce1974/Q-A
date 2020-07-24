<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function generatePDF(){
        $questions = Question::with('user')->paginate(5);
        $authenticated = Auth::check() ? true : false;
        $pdf = \PDF::loadView('questions.index', compact('questions', 'authenticated'));

        return $pdf->download('questions.pdf');

    }
}
