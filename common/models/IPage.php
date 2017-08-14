<?php

namespace common\models;

interface IPage
{
    public function getUrl();
    public function getTitle();
    public function getName();
    public function getUrlByLanguage(Language $language, $includingSelf);
    public function getTemplate();
    public function getStatusTitle();
}