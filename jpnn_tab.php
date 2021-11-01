<?php

function change_month_jpnn($month){

    if ($month == "Januari") {
        $month = "-01-";}

    elseif ($month == "Februari") {
        $month = "-02-";}

    elseif ($month == "Maret") {
        $month = "-03-" ;}

    elseif ($month == "April") {
        $month = "-04-"; }

    elseif ($month == "Mei") {
        $month = "-05-"; }

    elseif ($month == "Juni") {
        $month = "-06-"; }

    elseif ($month == "Juli") {
        $month = "-07-"; }

    elseif ($month == "Agustus") {
        $month = "-08-"; }

    elseif ($month == "September") {
        $month = "-09-";  }

    elseif ($month == "Oktober") {
        $month = "-10-"; }

    elseif ($month == "November") {
        $month = "-11-"; }

    elseif ($month == "Desember") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function


function jpnn_news($search_word) {
//initialising the variable
$jpnn_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//jpnn news

  $url = "http://www.jpnn.com/search?q=".$search_word."&sa=jpnn_search&tab=jpnn_search";
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $articles = $dom_xpath->query('//div[@class="content-list"]/h2');

  $count = 0;
  foreach ($articles as $article) {
        $title = $article->nodeValue;
        $jpnn_saved_file['title'][$count] = $title;
        $count = $count + 1;
    }

  $articles = $dom_xpath->query('//li[@data-offset="10"]/a');

  $count = 0;
  foreach ($articles as $article) {
        $link = $article->getAttribute('href');
        $jpnn_saved_file['link'][$count] = $link;
        $count = $count + 1;
        }


  $articles = $dom_xpath->query('//div[@class="rubrik"]/span[@class="color-silver light font-10"]');

  $count = 0;
  foreach ($articles as $article) {
        $date = $article->nodeValue;
        //Jumat, 01 September 2017
        $date = explode(',',$date)[1];
        $date = explode(' ',$date);
        $date1 = $date[3].change_month_jpnn($date[2]).$date[1];

        if ($date1 !== '') {
        $date1 = DateTime::createFromFormat('Y-m-j', $date1);
        $date1 = $date1->format('Y-m-d');  }


        $jpnn_saved_file['date'][$count] = $date1;
        $count = $count + 1;
    }









$count = 0;
foreach ($jpnn_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  //$inner_div = $dom->getElementById('jpnndetailtext')->getElementsByTagName('div');
  $dom_xpath = new DOMXpath($dom);

  $paras = $dom_xpath->query('//div[@class="post"]/p');

  $body = '';

  foreach ($paras as $para) {
    $body .= $para->nodeValue." ";
      }

  $pages = $dom_xpath->query('//li[@class=""]/a');


  /*
  if ($pages->length > 0) {

    for ($i=0; $i=$pages->length-1; $i++) {
      $page_url = $pages->item($i)->getAttribute('href');
      $html = fetch_http_file_contents($page_url);
      $dom = new domDocument;
      libxml_use_internal_errors(true);
      $dom->loadHTML($html);
      $dom_xpath = new DOMXpath($dom);
      $paras = $dom_xpath->query('//div[@class="post"]/p');
      foreach ($paras as $para) {
        $body .= $para->nodeValue." ";
          }


    }

  } */



  $jpnn_saved_file['body'][$count] = $body;
  $count = $count + 1;



} // end of foreach paras


  return $jpnn_saved_file;
} //end of jpnnnews function

?>
