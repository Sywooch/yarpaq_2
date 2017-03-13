<?php

namespace common\models;


interface IDocument
{
    public function getCreatedUser();
    public function getUpdatedUser();
}