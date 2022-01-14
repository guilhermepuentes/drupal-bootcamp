<?php

use simplehtmldom\HtmlWeb;
use Drupal\Core\File\FileSystemInterface;


require __DIR__ . '/../../../../../../vendor/autoload.php';

$news = getNews('https://www.squadra.com.br', '/blog');

$fp = fopen(__DIR__ . '/../scrape/blog-squadra.csv', 'w');
fputcsv($fp, ['title', 'link', 'body']);
foreach ($news as $news_item) {
  fputcsv($fp, $news_item);
}
fclose($fp);

function getNews(string $newsUrl, string $pageSegment = '', array $result = []): array {
  $simplehtmldom = new HtmlWeb();
  $html = $simplehtmldom->load($newsUrl . $pageSegment);
  foreach ($html->find('.row mb-3 post-single .mb-0 size-sm') as $newsRow) {
    $title = $newsRow->find('.mb-0 size-sm')[0] ?? NULL;

    $newsItemUrl = $newsUrl . $title->getAttribute('href');
    echo "$newsItemUrl\n";
    $newsItemPage = $simplehtmldom->load($newsItemUrl);
    $body = $newsItemPage->find('.article')[0] ?? NULL;

    $result[] = [
      'title' => $title ? $title->innerText() : '',
      'link' => $newsItemUrl,
      'body' => $body ? $body->innerText() : '',
    ];
  }
  if ($nextPage = $html->find('.alm-btn-wrap')[0] ?? NULL) {
    $nextPageSegment = $nextPage->getAttribute('href');
    $result = getNews($newsUrl, $nextPageSegment, $result);
  }
  return $result;
}
