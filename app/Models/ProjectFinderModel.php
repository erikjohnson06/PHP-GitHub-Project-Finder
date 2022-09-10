<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\GitHubRepositoryRecord;

class ProjectFinderModel extends Model
{
    protected $table = 'github_projects';
    
    protected $allowedFields = ['repository_id', 'name', 'url', 'description', 'stars',  'date_created', 'last_updated'];
    
    protected $error_msg;
        
    public function __construct() //ConnectionInterface $db
    {
        parent::__construct();
                
        //$db = \Config\Database::connect();
        
        if (!class_exists("GitHubRepositoryRecord")){
            require_once APPPATH."Libraries/Custom/GitHubRepositoryRecord.php";
        }
    }     

    public function getErrorMsg(){
        return $this->error_msg;
    }
    
//    public function getProjectList()
//    {
//        return $this->findAll();        
//    }
    
    /**
     * Retrieve a list of project records
     * 
     * @return GitHubRepositoryRecord[]|boolean
     * @throws \Exception
     */
    public function getProjectList()
    {
                
        //$query   = $this->db->get('github_projects');
        $data = array();
        
        try {
            
            $query = $this->db->query('SELECT repository_id, name FROM github_projects ORDER BY stars ASC');
            //$results = $query->getResult();
            
            if (!$query){
                $error = $this->db->error();
                log_message("error", "db error?" . print_r($error, true));
                throw new \Exception($error['message'] . " (" . $error['code'] . ")");
            }

            if ($query->getNumRows() > 0){
                
                foreach ($query->getResultObject() as $row){

                    $obj = new GitHubRepositoryRecord();
                    $obj->repository_id = $row->repository_id;
                    $obj->name = $row->name;

                    $data[] = $obj;
                }
            }
            
        } catch (\Exception $ex) {
            $this->error_msg = $ex->getMessage();
            log_message("error", $this->error_msg);
            return false;
        }
        
        return $data;        
    }
    
    /**
     * Insert/Update a list of project records
     * 
     * @param GitHubRepositoryRecord[] $data
     * @return boolean
     * @throws \Exception
     */
    public function upsertProjectRecords($data = array())
    {
        
        log_message("error", "upsertProjectRecords...");
        /*
        if (!$data){
            $this->error_msg = "Data not found or is invalid";
            return false;
        }

        if (!is_array($data)){
            
            //Allow for a single record
            if (is_a($data, "App\Libraries\GitHubRepositoryRecord")){
                $data = array($data);
            }
            else {
                $this->error_msg = "Data not found or is invalid";
                return false;
            }
        }
        */

        $obj = new GitHubRepositoryRecord();
        $obj->repository_id = 333;
        $obj->name = "Test 3";
        $data = array($obj);
        
        log_message("error", print_r($data, true));
        
        try {
            
            foreach ($data as $record){
                
                //Restrict the insertion of new records to the standardized record format
                if (!is_a($record, "App\Libraries\GitHubRepositoryRecord")){
                    continue;
                }
                
                $query = "INSERT INTO github_projects " . 
                        " (repository_id, name, url, description, stars, date_created, last_updated) " . 
                        " VALUES ('" . $record->repository_id . "', " . 
                                "'" . $record->name . "', " . 
                                "'" . $record->url . "', " . 
                                "'" . $record->description . "', " . 
                                "'" . $record->stars . "', " . 
                                "'" . $record->date_created . "', " . 
                                "'" . $record->last_updated . "') " . 
                        " ON DUPLICATE KEY UPDATE "  . 
                        " name = '" . $record->name . "', " . 
                        " url = '" . $record->url . "', " .         
                        " description = '" . $record->description . "', " .         
                        " stars = '" . $record->stars . "', " . 
                        " last_updated = '" . $record->last_updated . "'";
                
                log_message("error", $query);
                
                $this->db->query($query);
            }
            
            //$results = $query->getResult();
            
            
//            if (!$query){
//                $error = $this->db->error();
//                log_message("error", "db error?" . print_r($error, true));
//                throw new \Exception($error['message'] . " (" . $error['code'] . ")");
//            }

            
        } catch (\Exception $ex) {
            $this->error_msg = $ex->getMessage();
            log_message("error", $this->error_msg);
            return false;
        }
        
        return $data;        
    }
    
    public function loadGitHubProjects(){
        
        
        
    }
}
