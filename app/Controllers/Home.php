<?php

namespace App\Controllers;

use App\Models\ProjectFinderModel;

class Home extends BaseController
{       
    
    public function index()
    {        
        return view('templates/head')
            . view('templates/header')
            . view('templates/sidebar')
            . view('project_finder')
            . view('templates/footer');
    }
}
