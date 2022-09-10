<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        //parent::__construct();
        
        
    }            
    
    public function index()
    {
        
        $model = model(ProjectModel::class);
        
        $data = ['project_data' => $model->getProjectList()];
        
        return view('project_finder', $data);
    }
}
