<?php

namespace App\Controllers;

use App\Models\ProjectFinderModel;
use App\Libraries\ReturnPayload;

class ProjectFinderJS extends BaseController
{
    public function __construct()
    {
        //parent::__construct();
        
        if (!class_exists("ReturnPayload")){
            require_once APPPATH."Libraries/Custom/ReturnPayload.php";
        }
    }            
    
    public function index()
    {
        
        $model = model(ProjectFinderModel::class);
        
        $data = ['project_data' => $model->getProjectList()];
        
        return view('project_finder', $data);
    }
    
    public function test(){
        
        //$post = $this->request->getVar();
        
        $model = model(ProjectFinderModel::class);
        
        // Read new token and assign in $data['token']
        
        log_message("error", "calling upsertProjectRecords...");
        
        $model->upsertProjectRecords();
        
        $data = new ReturnPayload();
        /*
        $data->error = false;
        $data->error_msg = "";
        $data->data = new \stdClass();
        $data->data->token = csrf_hash();
        $data->data->project_data = $model->getProjectList();
        $data->data->post_data = $post;
        */
        //echo $this->response->setJSON($data);
        echo json_encode($data);
        exit();
    }
    
    public function getProjectList(){
        
        $post = $this->request->getVar();
        
        $model = model(ProjectFinderModel::class);
        
        $data = new ReturnPayload();
        $data->error = false;
        $data->error_msg = "";
        $data->data = new \stdClass();
        $data->data->token = csrf_hash(); //Generate new token
        $data->data->project_data = $model->getProjectList();
        $data->data->post_data = $post;
        
        if ($model->getErrorMsg()){
            $data->error = true;
            $data->error_msg = $model->getErrorMsg();            
        }
        
        //echo $this->response->setJSON($data);
        echo json_encode($data);
        exit();
    }
    
    public function loadGitHubProjects(){
        
        $model = model(ProjectFinderModel::class);
        
        $model->getProjectList();
        
        echo json_encode($data);
        exit();
    }
}
