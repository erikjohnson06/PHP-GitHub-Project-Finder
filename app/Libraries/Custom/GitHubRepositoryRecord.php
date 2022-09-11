<?php

namespace App\Libraries;

/**
 * Summary class for GitHub project records
 */
class GitHubRepositoryRecord
{
    /**
     * @var int
     */
    public $repository_id = 0;
    
    /**
     * @var int
     */
    public $stargazers_count = 0;
    
    /**
     * @var string
     */
    public $name;
}
