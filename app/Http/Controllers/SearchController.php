<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function index() {
        $groupedCategories = Session::get('groupedCategories');

        return view('search',compact('groupedCategories'));
    }


}
