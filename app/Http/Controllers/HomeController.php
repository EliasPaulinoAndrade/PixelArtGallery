<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\QFEloquent\QFModel;
use App\Peca;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pecasByDate = Peca::getSortedByDate($limit = 15);
        $pecasByEvaluation = Peca::getBestEvalueted($limit = 15);

        
        return view('home', compact("pecasByDate", "pecasByEvaluation"));
    }
    
}
