<?php

namespace common\components\image;

interface IImageVariation
{
    /**
     * Возвращает URL картинки
     *
     * @return mixed
     */
    public function getUrl();

    /**
     * Возвращает путь к картинки
     *
     * @return mixed
     */
    public function getPath();
}