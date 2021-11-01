<?php

function change_month_kompasiana($month){

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

function kompasiana_news($search_word) {
//initialising the variable
$kompasiana_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//search_artikel?q=singapura
//kompasiana news
  $url = 'https://www.kompasiana.com/search_artikel?q='.$search_word;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

//thumb-user clearfix

  $articles = $dom_xpath->query('//div[@class="artikel--content"]/h2');
  //$dates= $dom_xpath->query('//span[@class="date"]');

  $count = 0;
  foreach ($articles as $article) {

        if ($article->getElementsByTagName("a")->item(0) != null) {
        $link = $article->getElementsByTagName("a")->item(0)->getAttribute('href');
        $title_link = $article->getElementsByTagName("a")->item(0)->nodeValue;


        $kompasiana_saved_file['title'][$count] = $title_link;
        $kompasiana_saved_file['link'][$count] = $link;
        $count =$count + 1;
        }
        //if ($count == 6) {break;}
  }



$count = 0;
foreach ($kompasiana_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);
  //$inner_div = $dom->getElementById('kompasianadetailtext')->getElementsByTagName('div');
//read-content read__keyword col-lg-9 col-md-9 col-sm-9 col-xs-9

  $paras = $dom_xpath->query('//div[@class="read-content read__keyword col-lg-9 col-md-9 col-sm-9 col-xs-9"]/p');

  $body = '';

  foreach ($paras as $para) {
  $body .= $para->nodeValue."<br>";
    }

  $kompasiana_saved_file['body'][$count] = $body;

  $date2 = $dom_xpath->query('//span[@class="count-item"]')->item(0)->nodeValue;
  //22 Maret 2020 | 2 hari lalu

  $date1 = explode(' ',$date2);

  $date1 = $date1[2].change_month_kompasiana($date1[1]).$date1[0];;


  if (strlen($date1) > 0) {
    $date1 = DateTime::createFromFormat('Y-m-j', $date1);
    $date1 = $date1->format('Y-m-d'); }
    $kompasiana_saved_file['date'][$count] = $date1;

    $count = $count + 1;
} //end of foreach ($kompasiana_saved_file['link'] as $url_page)

  return $kompasiana_saved_file;
} //end of kompasiananews function

?>
