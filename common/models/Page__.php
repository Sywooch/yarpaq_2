<?php

namespace common\models;


class Page
{

    const STATUS_ON = 1;
    const STATUS_LOCKED = 4;
    const STATUS_SYSTEM_ID = 8;
    const STATUS_SYSTEM = 16;
    const STATUS_HIDDEN = 1024;
    const STATUS_UNPUBLISHED = 2048;
    const STATUS_TRASH = 8192;

    private $id;
    private $name;
    private $title;
    private $path;
    private $url;
    private $httpUrl;
    private $parent;
    private $parentID;
    private $parents;
    private $rootParent;
    private $template;
    private $fields;
    private $numChildren;
    private $children;
    private $child;
    private $siblings;
    private $next;
    private $prev;
    private $created;
    private $midified;
    private $published;
    private $createdUser;
    private $modifiedUser;
    private $publishedUser;
    private $status;
    private $sort;


}