<?php

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Route\Exception\NotFoundException;

/**
 * These routes are for demonstration purpose, to show how routes and
 * handlers can be created.
 */
return [
    "routes" => [
        [
            "mount" => "thread",
            "handler" => "\Hab\Controller\ThreadController"
        ],
    ]
];
