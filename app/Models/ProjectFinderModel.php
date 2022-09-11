<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\GitHubRepositoryRecord;
use App\Libraries\GitHubApiCurlRequest;

class ProjectFinderModel extends Model
{
    protected $table = 'github_projects';
    
    protected $allowedFields = ['repository_id', 'name', 'url', 'description', 'stars',  'date_created', 'last_updated'];
    
    protected $error_msg;
    
    protected $user_agent;    
    
    public function __construct() //ConnectionInterface $db
    {
        parent::__construct();
                
        //$db = \Config\Database::connect();
        
        if (!class_exists("GitHubRepositoryRecord")){
            require_once APPPATH."Libraries/Custom/GitHubRepositoryRecord.php";
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
            if (is_a($data, "App\Libraries\GitHubRepositoryRecord")){
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
                if (!is_a($record, "App\Libraries\GitHubRepositoryRecord")){
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
                
                //log_message("error", $query);
                
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

            $page = 1;
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
                    $record = new GitHubRepositoryRecord();
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
                
                //As a failsafe, break after 200 queries (although this "should" never happen)
                if ($page > 200){
                    break;
                }
            }
        }
        catch (Exception $ex){
            $this->error_msg = "cURL Request Error: " . $ex->getMessage();
            log_message("error", $this->error_msg);
        }
        finally {
            $curl->close_cURL(); //Close the connection
        }
    }
}
