<?php
use yii\helpers\Url;

echo '<?xml version="1.0" encoding="UTF-8"?>';

echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($categories as $category) {
    echo '
    <url>

        <loc>'.Url::to($category->url, true).'</loc>

        <lastmod>'.$category->updated_at.'</lastmod>

        <changefreq>daily</changefreq>

        <priority>0.8</priority>

    </url>
    ';
}


echo '</urlset>';