<?php

namespace App\Controllers;

use App\Models\ProjectFinderModel;

class Home extends BaseController
{       
    
    public function index()
    {
        return view('project_finder');
    }
}
