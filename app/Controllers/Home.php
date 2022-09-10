<?php

namespace App\Controllers;

use App\Models\ProjectFinderModel;

class Home extends BaseController
{       
    
    public function index()
    {
        
        $model = model(ProjectFinderModel::class);
        
        $data = ['project_data' => $model->getProjectList()];
        
        return view('project_finder', $data);
    }
}
