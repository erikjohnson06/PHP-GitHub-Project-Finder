<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\GitHubRepositoryRecord;
use App\Libraries\GitHubRepositoryRecordDetail;
use App\Libraries\GitHubApiCurlRequest;

class ProjectFinderModel extends Model
{
    protected $table = 'github_projects';
    
    protected $allowedFields = ['repository_id', 'name', 'url', 'description', 'stars',  'date_created', 'last_updated'];
    
    protected $error_msg = "";
    
    protected $user_agent = "";    
    
    public function __construct() //ConnectionInterface $db
    {
        parent::__construct();
                
        //$db = \Config\Database::connect();
        
        if (!class_exists("GitHubRepositoryRecord")){
            require_once APPPATH."Libraries/Custom/GitHubRepositoryRecord.php";
        }
        
        if (!class_exists("GitHubRepositoryRecordDetail")){
            require_once APPPATH."Libraries/Custom/GitHubRepositoryRecordDetail.php";
        }
        
        if (!class_exists("GitHubApiCurlRequest")){
            require_once APPPATH."Libraries/Custom/GitHubApiCurlRequest.php";
        }       
    }     

    public function getErrorMsg()
    {
        return $this->error_msg;
    }
    
    public function setUserAgent($val = "")
    {
        $this->user_agent = $val;
    }
    
    /**
     * Retrieve a list of project records
     * 
     * @return GitHubRepositoryRecord[]|boolean
     * @throws \Exception
     */
    public function getProjectList()
    {
        $data = array();
        
        try {
            
            $query = "SELECT repository_id, name, stargazers_count " . 
                    " FROM github_projects " . 
                    " ORDER BY stargazers_count DESC";
            
            $results = $this->db->query($query);
            
            if (!$results){
                $error = $this->db->error();
                log_message("error", "Unable to get project list: " . print_r($error, true));
                throw new \Exception($error['message'] . " (" . $error['code'] . ")");
            }

            if ($results->getNumRows() > 0){
                
                foreach ($results->getResultObject() as $row){

                    $obj = new GitHubRepositoryRecord();
                    $obj->repository_id = $row->repository_id;
                    $obj->name = $row->name;
                    $obj->stargazers_count = $row->stargazers_count;

                    $data[] = $obj;
                }
            }
        }
        catch (\Exception $ex) {
            $this->error_msg = $ex->getMessage();
            log_message("error", $this->error_msg);
            return false;
        }
        
        return $data;        
    }
    
    /**
     * Retrieve detail for a project
     * 
     * @param int $id
     * @return GitHubRepositoryRecordDetail|boolean
     * @throws \Exception
     */
    public function getProjectListDetail($id = 0)
    {
        $data = null;
        
        if (!$id){
            return false;
        }
        
        try {

            $query = "SELECT repository_id, name, html_url, description, stargazers_count, " . 
                    " DATE_FORMAT(created_at, '%c/%e/%Y %l:%i %p') AS create_date, " . 
                    " DATE_FORMAT(pushed_at, '%c/%e/%Y %l:%i %p') AS pushed_date  " . 
                    " FROM github_projects " . 
                    " WHERE repository_id = " . (int) $id;
            
            $results = $this->db->query($query);
            
            if (!$results){
                $error = $this->db->error();
                log_message("error", "Unable to find project detail: " . print_r($error, true));
                throw new \Exception($error['message'] . " (" . $error['code'] . ")");
            }

            $row = $results->getRow();
                        
            $data = new GitHubRepositoryRecord();
            $data->repository_id = (int) $row->repository_id;
            $data->name = utf8_decode(htmlentities($row->name, ENT_QUOTES));
            $data->description = utf8_decode(htmlentities($row->description, ENT_QUOTES));
            $data->html_url = htmlentities($row->html_url);//urlencode();
            $data->stargazers_count = (int) $row->stargazers_count;
            $data->created_at = $row->create_date;
            $data->pushed_at = $row->pushed_date;            
        }
        catch (\Exception $ex) {
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
                
        if (!$data){
            $this->error_msg = "Data not found or is invalid";
            return false;
        }

        if (!is_array($data)){
            
            //Allow for a single record push
            if (is_a($data, "App\Libraries\GitHubRepositoryRecordDetail")){
                $data = array($data);
            }
            else {
                $this->error_msg = "Data not found or is invalid";
                return false;
            }
        }
        
        try {
            
            foreach ($data as $record){
                
                //Restrict the insertion of new records to the standardized record format
                if (!is_a($record, "App\Libraries\GitHubRepositoryRecordDetail")){
                    continue;
                }

                $query = "INSERT INTO github_projects " . 
                        " (repository_id, name, html_url, description, stargazers_count, created_at, pushed_at) " . 
                        " VALUES (" . $record->repository_id . ", " . 
                                "" . $this->db->escape($record->name) . ", " . 
                                "" . $this->db->escape($record->html_url) . ", " . 
                                "" . $this->db->escape($record->description) . ", " . 
                                "" . $record->stargazers_count . ", " . 
                                "'" . $record->created_at . "', " . 
                                "'" . $record->pushed_at . "') " . 
                        " ON DUPLICATE KEY UPDATE "  . 
                        " name = " . $this->db->escape($record->name) . ", " . 
                        " html_url = " . $this->db->escape($record->html_url) . ", " .         
                        " description = " . $this->db->escape($record->description) . ", " .         
                        " stargazers_count = " . $record->stargazers_count . ", " . 
                        " pushed_at = '" . $record->pushed_at . "'";
                
                log_message("error", $query);
                
                if (!$this->db->query($query)){
                    $error = $this->db->error();
                    throw new \Exception($error['message'] . " (" . $error['code'] . ")");
                }
            }
        } 
        catch (\Exception $ex) {
            $this->error_msg = $ex->getMessage();
            log_message("error", $this->error_msg);
            return false;
        }
        
        return true;
    }
    
    /**
     * Call the GitHub API via a cURL request and load records in the local DB
     * 
     * @return boolean
     * @throws \Exception
     */
    public function loadGitHubProjects()
    {
        
        if (!$this->user_agent){
            return false;
        }
                  
        $curl = new GitHubApiCurlRequest();
        $curl->init_cURL();
        $curl->setUserAgent($this->user_agent);
        $curl->setPerPage(100); //Max block is 100 per request
        
        try {

            //Prevent running multiple requests from being submitted. No need to throw an exception here. Just check for the error message in the controller.
            if ($this->isRequestProcessRunning()){
                $this->error_msg = "Request is already running. Try again once complete.";
                return false;
            }
            
            //Mark the request as started
            $this->updateRequestManager(true);
            
            $page = 1;
            $number_of_requests = 0;
            $iso_format = "Y-m-d\TH:i:sO"; //Default GitHub Date format
            $sql_format = "Y-m-d H:i:s"; //Default to SQL format
                        
            while (true){
                                
                $curl->setPageNumber($page);

                $items = $curl->submitGitSearchRequest();

                //log_message("error", "page: " . $page);

                if ($curl->getErrorMsg()){
                    throw new \Exception($curl->getErrorMsg());
                }

                //Halt once the result set has been exhausted
                if (!$items){
                    break;
                }

                $records = array();

                foreach ($items as $item){

                    //Extract the pertinent info from the items array and update the db
                    $record = new GitHubRepositoryRecordDetail();
                    $record->repository_id = $item->id;
                    $record->name = $item->name;
                    $record->html_url = $item->html_url;
                    $record->description = $item->description;
                    $record->stargazers_count = $item->stargazers_count;

                    //GitHub datetimes are in the ISO 8601 format. Convert these to MySQL datetimes.        
                    $create_dt = \DateTime::createFromFormat($iso_format, $item->created_at);
                    $pushed_dt = \DateTime::createFromFormat($iso_format, $item->pushed_at);

                    $record->created_at = $create_dt->format($sql_format); 
                    $record->pushed_at = $pushed_dt->format($sql_format); 

                    $records[] = $record;
                }

                //Insert records into DB
                $this->upsertProjectRecords($records);
                
                $page++; //Increase pagination
                $number_of_requests++;
                
                //GitHub limits 30 requests per minute
                if ($number_of_requests > 1){
                    break;
                }
            }
        }
        catch (\Exception $ex){
            $this->error_msg = "cURL Request Error: " . $ex->getMessage();
            log_message("error", $this->error_msg);
        }
        finally {
            $curl->close_cURL(); //Close the connection
            $this->updateRequestManager(false, $this->error_msg);
        }
    }
        
    /**
     * Update the request manager table, marking start times, end times, and recording error messages
     * 
     * @param boolean $starting_new_request
     * @param string $error_msg
     * @throws \Exception
     */
    private function updateRequestManager($starting_new_request = false, $error_msg = ""){
        
        try {
            
            $query = "UPDATE github_projects_request_manager ";

            //Clear error message if starting
            if ($starting_new_request){
                $query .= "SET is_running = 1, start_time = NOW(), error_msg = NULL ";
            }
            else {
                $query .= "SET is_running = 0, end_time = NOW() ";

                if ($error_msg){
                    $query .= "SET error_msg = " . $this->db->escape($error_msg);
                }
            }

            if (!$this->db->query($query)){
                $error = $this->db->error();
                throw new \Exception($error['message'] . " (" . $error['code'] . ")");
            }
        } 
        catch (\Exception $ex) {
            $this->error_msg = "Request Manager Error: " . $ex->getMessage();
            log_message("error", $this->error_msg);
        }
    }
    
    /**
     * Determine if another cURL request is currently underway
     * 
     * @return boolean
     */
    private function isRequestProcessRunning(){
        
        try {
            
            $results = $this->db->query("SELECT is_running FROM github_projects_request_manager ");
                                   
            if (!$results || !$results->getNumRows()){
                
                log_message("notice", "No entry found in the request manager. Recreating..");
                
                //It's possible that the table is empty. If so, add the required entry into the table. 
                $query = "TRUNCATE TABLE github_projects_request_manager";
                $this->db->query($query);
                
                $query = "INSERT github_projects_request_manager (is_running, start_time, end_time, error_msg)" .
                         "VALUES (0, NULL, NULL, NULL)";                
                $this->db->query($query);
                
                return false;
            }

            $row = $results->getRow();
            
            if ($row && isset($row->is_running) && $row->is_running > 0){
                return true;
            }
        } 
        catch (\Exception $ex) {
            $this->error_msg = "Request Manager Error: " . $ex->getMessage();
            log_message("error", $this->error_msg);
        }
        
        return false;
    }
        
    /**
     * Determine the time a cURL request was performed
     * 
     * @return string|boolean
     */
    public function getLastUpdateTime(){
        
        try {
            
            $results = $this->db->query("SELECT DATE_FORMAT(end_time, '%c/%e/%Y %l:%i %p') AS last_updated FROM github_projects_request_manager");
                                   
            if (!$results || !$results->getNumRows()){
                return false;
            }

            $row = $results->getRow();
            
            if ($row && isset($row->last_updated) && $row->last_updated != "0000-00-00 00:00:00" ){
                return $row->last_updated;
            }
        } 
        catch (\Exception $ex) {
            $this->error_msg = "Request Manager Error: " . $ex->getMessage();
            log_message("error", $this->error_msg);
        }
        
        return false;
    }
}
