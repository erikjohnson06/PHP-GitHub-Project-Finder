<?php

namespace App\Controllers;

use App\Models\ProjectFinderModel;
use App\Libraries\ReturnPayload;

class ProjectFinderJS extends BaseController
{
    public function __construct()
    {        
        if (!class_exists("ReturnPayload")){
            require_once APPPATH."Libraries/Custom/ReturnPayload.php";
        }
    }            
    
    public function index()
    {        
        return view('project_finder');
    }
    
    /**
     * Controller for calling GitHub API and updating database with fresh projects. 
     */
    public function loadGitHubProjects()
    {
        $data = new ReturnPayload();
        $data->data = new \stdClass();
        $data->data->token = csrf_hash(); //Generate new token
        
        $model = model(ProjectFinderModel::class);
        
        $agent = $this->request->getServer("HTTP_USER_AGENT"); //Retreive the user agent for the cUrl request

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
            exit();
        }
        
        $data->data->project_data = $model->getProjectList();
        $data->data->last_updated = $model->getLastUpdateTime();
        
        $data->data->success_msg = "GitHub Projects updated successfully.";

        echo json_encode($data);
        exit();
    }
    
    /**
     * Controller for retrieving projects from the database.
     */
    public function getProjectList()
    {        
        $data = new ReturnPayload();
        $data->data = new \stdClass();
        $data->data->token = csrf_hash(); //Generate new token for subsequent ajax calls. 
        
        $model = model(ProjectFinderModel::class);
        
        $data->data->project_data = $model->getProjectList();
        $data->data->last_updated = $model->getLastUpdateTime();
        
        if ($model->getErrorMsg()){
            $data->error = true;
            $data->error_msg = $model->getErrorMsg();            
        }
        
        echo json_encode($data);
        exit();
    }
        
    /**
     * Controller for retrieving detail for a particular project based on repository ID
     */
    public function getProjectListDetail(){
        
        $data = new ReturnPayload();
        $data->data = new \stdClass();
        $data->data->token = csrf_hash(); //Generate new token for subsequent ajax calls. 
        
        $post = $this->request->getVar();
        
        if (!$post || !isset($post['repo_id'])){
            $data->error = true;
            $data->error_msg = "Invalid repository";
            echo json_encode($data);
            exit();
        }
        
        $repo_id = (int) $post['repo_id'];
                
        $model = model(ProjectFinderModel::class);
        $data->data->project_data = $model->getProjectListDetail($repo_id);
       
        if ($model->getErrorMsg()){
            $data->error = true;
            $data->error_msg = $model->getErrorMsg();            
        }
        
        echo json_encode($data);
        exit();
    }
}
