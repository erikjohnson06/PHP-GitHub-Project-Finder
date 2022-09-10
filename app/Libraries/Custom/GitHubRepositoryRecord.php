<?php

namespace App\Libraries;

class GitHubRepositoryRecord
{
    /**
     * @var int
     */
    //public $id = 0;
    public $repository_id;
    public $stars = 0;
    
    /**
     * @var string
     */
    public $name;
    public $url;
    public $description;
    public $date_created;
    public $last_updated;
}
