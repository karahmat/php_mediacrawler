<?php

function chappy_news($search_word) {
//initialising the variable
$chappy_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];


//chappy news
  $url = 'http://www.chappyhakim.com/?s='.$search_word.'&orderby=post_date';
  $html = file_get_contents($url);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $articles = $dom_xpath->query("//div[@class='post-details']/h3/a");
  //$dates= $dom_xpath->query('//span[@class="date meta-item"]');

  $count = 0;
  foreach ($articles as $article) {

        $link = $article->getAttribute('href');
        $title_link = $article->nodeValue;
        $chappy_saved_file['title'][$count] = $title_link;
        $chappy_saved_file['link'][$count] = $link;
        $count =$count + 1;

        //if ($count == 6) {break;}
  }

  $count = 0;
  foreach ($chappy_saved_file['link'] as $url_page) {

    $html = file_get_contents($url_page);
    /*** a new dom object ***/

    $dom = new domDocument;
    libxml_use_internal_errors(true);
    /*** load the html into the object ***/
    $dom->loadHTML($html);
    $dom_xpath = new DOMXpath($dom);

    $paras = $dom_xpath->query("//div[@class='entry-content entry clearfix']/p");
    $fulltext = '';

    foreach ($paras as $para) {

      $fulltext = $fulltext.'<br>'.$para->nodeValue;
    }
    $chappy_saved_file['body'][$count] = $fulltext;

    $date = $dom_xpath->query("/html/head/meta[@property='article:modified_time']")->item(0)->getAttribute('content');
    $date_value = explode('T',$date)[0];
    $chappy_saved_file['date'][$count] = $date_value;



    $count = $count + 1;
  }

  return $chappy_saved_file;
} //end of chappynews function

//$chappy_result = chappy_news('wilayah+udara');

//echo $chappy_result['date'][1].'<br>';
//echo $chappy_result['link'][1].'<br>';
//echo $chappy_result['title'][1].'<br><br>';
//echo $chappy_result['body'][1].'<br>';

?>
