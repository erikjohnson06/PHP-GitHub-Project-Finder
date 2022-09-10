<?php

namespace App\Libraries;

class ReturnPayload
{
    /**
     * @var bool
     */
    public bool $error = false;

    /**
     * @var string
     */
    public string $error_msg = "";

    /**
     * @var null|mixed
     */
    public $data = null;
}
