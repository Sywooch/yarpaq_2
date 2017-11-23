<?php
use yii\helpers\Url;
use common\models\Language;

$languages = Language::find()->all();

echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:xhtml="http://www.w3.org/1999/xhtml">'.PHP_EOL;

foreach ($products as $product) {
    echo '<url>';
    echo '<loc>'.Url::to($product->url, true).'</loc>'.PHP_EOL;

    foreach ($languages as $language) {
        if ($language->isDefault()) continue;

        echo '<xhtml:link rel="alternate" hreflang="'.$language->name.'" href="'.Url::to($product->getUrlByLanguage($language), true).'" />'.PHP_EOL;
    }


    echo '
        <lastmod>'.( new \DateTime($product->updated_at))->format('Y-m-d').'</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    ';
}

echo '</urlset>';