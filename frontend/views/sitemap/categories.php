<?php
use yii\helpers\Url;
use common\models\Language;

$languages = Language::find()->all();

echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:xhtml="http://www.w3.org/1999/xhtml">'.PHP_EOL;

foreach ($categories as $category) {

    $urls = [];
    $href_lang_markup = '';
    foreach ($languages as $language) {
        $url = Url::to($category->getUrlByLanguage($language), true);
        $urls[$language->id] = $url;
        $href_lang_markup .= '<xhtml:link rel="alternate" hreflang="' . $language->name . '" href="' . $url . '" />' . PHP_EOL;
    }

    foreach ($languages as $language) {
        echo '<url>';
        echo '<loc>' . $urls[$language->id] . '</loc>' . PHP_EOL;
        echo $href_lang_markup;
        echo '
            <lastmod>' . (new \DateTime($category->updated_at))->format('Y-m-d') . '</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        ';
    }
}

echo '</urlset>';