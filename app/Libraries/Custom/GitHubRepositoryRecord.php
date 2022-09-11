<?php

namespace App\Libraries;

class GitHubRepositoryRecord
{
    /**
     * @var int
     */
    public $repository_id = 0;
    public $stargazers_count = 0;
    
    /**
     * @var string
     */
    public $name;
    public $html_url;
    public $description;
    public $created_at;
    public $pushed_at;
}
