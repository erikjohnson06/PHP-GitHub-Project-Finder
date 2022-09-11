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
    
    public function loadGitHubProjects(){
                
        $data = new ReturnPayload();
        
        $model = model(ProjectFinderModel::class);
        
        $agent = $this->request->getServer("HTTP_USER_AGENT"); //Retreive the user agent for the cUrl request
        
        log_message("error", "calling loadGitHubProjects..." . $agent);
        
        if (!$agent){
            $data->error = true;
            $data->error_msg = "User Agent Required for GitHub API Request.";
            echo json_encode($data);
            exit();
        }
        
        $model->setUserAgent($agent);
        $model->loadGitHubProjects();
        
        if ($model->getErrorMsg()){
            $data->error = true;
            $data->error_msg = $model->getErrorMsg();
            echo json_encode($data);
            return false;
        }
        
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
        
        //$post = $this->request->getVar();
        
        $model = model(ProjectFinderModel::class);
        
        $data = new ReturnPayload();
        $data->error = false;
        $data->error_msg = "";
        $data->data = new \stdClass();
        $data->data->token = csrf_hash(); //Generate new token
        $data->data->project_data = $model->getProjectList();
        //$data->data->post_data = $post;
        
        if ($model->getErrorMsg()){
            $data->error = true;
            $data->error_msg = $model->getErrorMsg();            
        }
        
        //echo $this->response->setJSON($data);
        echo json_encode($data);
        exit();
    }
        
    public function getProjectListDetail(){
        
        $post = $this->request->getVar();
        
        log_message("error", "getProjectListDetail..." . print_r($post['id'], true));
        
        $model = model(ProjectFinderModel::class);
        
        $data = new ReturnPayload();
        
        /*
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
        */
        //echo $this->response->setJSON($data);
        echo json_encode($data);
        exit();
    }
}
