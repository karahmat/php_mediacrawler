<?php

function change_month_arahkita($month){

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

function arahkita_news($search_word) {
//initialising the variable
$arahkita_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];


//arahkita news
  $url = 'https://www.arahkita.com/cari/'.$search_word;
  $html = fetch_http_file_contents($url);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $articles = $dom_xpath->query("//div[@class='main-loop-content left-offset']/h2/a");
  $dates = $dom_xpath->query("//div[@class='main-loop-content left-offset']/h2/span[@class='time']");

  $count = 0;
  foreach ($articles as $article) {

        $link = $article->getAttribute('href');
        $title_link = $article->nodeValue;
        $arahkita_saved_file['title'][$count] = $title_link;
        $arahkita_saved_file['link'][$count] = $link;
        $count =$count + 1;

        //if ($count == 6) {break;}
  }

  $count = 0;
  foreach ($dates as $date) {
    //Rabu, 24 Juli 2019 | Internasional
    $date_value = explode(' ',$date->nodeValue);
    $date1 = $date_value[3].change_month_arahkita($date_value[2]).$date_value[1];
    //echo $date1.'<br>';
    $arahkita_saved_file['date'][$count] = $date1;

    $count =$count + 1;
  }


  $count = 0;
  foreach ($arahkita_saved_file['link'] as $url_page) {

    $html = fetch_http_file_contents($url_page);
    /*** a new dom object ***/

    $dom = new domDocument;
    libxml_use_internal_errors(true);
    /*** load the html into the object ***/
    $dom->loadHTML($html);
    $dom_xpath = new DOMXpath($dom);

    $paras = $dom_xpath->query("//div[@class='content entry-content']/p");
    $fulltext = '';

    foreach ($paras as $para) {

      $fulltext = $fulltext.'<br>'.$para->nodeValue;
    }
    $arahkita_saved_file['body'][$count] = $fulltext;
    $count = $count + 1;
  }

  return $arahkita_saved_file;
} //end of arahkitanews function

//$arahkita_result = arahkita_news('Singapura');

//echo $arahkita_result['date'][4].'<br>';
//echo $arahkita_result['link'][4].'<br>';
//echo $arahkita_result['title'][4].'<br><br>';
//echo $arahkita_result['body'][4].'<br>';

?>
