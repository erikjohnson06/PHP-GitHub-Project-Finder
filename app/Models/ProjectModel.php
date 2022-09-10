<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'github_projects';
    
    protected $allowedFields = ['repository_id', 'name', 'url', 'description', 'stars',  'date_created', 'last_updated'];
    
    public function getProjectList()
    {

        return $this->findAll();        
    }
}
