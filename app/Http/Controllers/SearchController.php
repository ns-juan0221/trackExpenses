<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function index() {
        $groupedOutcomeCategories = Session::get('groupedOutcomeCategories');

        return view('log',compact('groupedOutcomeCategories'));
    }


}
