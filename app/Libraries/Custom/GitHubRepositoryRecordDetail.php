<?php

namespace App\Libraries;
use App\Libraries\GitHubRepositoryRecord;

/**
 * Detail class for GitHub project records
 */
class GitHubRepositoryRecordDetail extends GitHubRepositoryRecord
{
    
    /**
     * @var string
     */
    public $html_url;
    
    /**
     * @var string
     */
    public $description;
    
    /**
     * @var string
     */
    public $created_at;
    
    /**
     * @var string
     */
    public $pushed_at;
}
