<?php

function change_month_arahairpower($month){

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

function arahairpower_news() {
//initialising the variable
$arahairpower_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];


//arahairpower news
  $url = "https://www.arahkita.com/airpowercorner/";
  $html = fetch_http_file_contents($url);
  //echo $html;
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
        //echo $link.'<br>';
        $title_link = $article->nodeValue;
        $arahairpower_saved_file['title'][$count] = $title_link;
        $arahairpower_saved_file['link'][$count] = $link;
        $count =$count + 1;

        //if ($count == 6) {break;}
  }

  $count = 0;
  foreach ($dates as $date) {
    //Rabu, 24 Juli 2019 | Internasional
    $date_value = explode(' ',$date->nodeValue);
    $date1 = $date_value[3].change_month_arahairpower($date_value[2]).$date_value[1];
    //echo $date1.'<br>';
    $arahairpower_saved_file['date'][$count] = $date1;

    $count =$count + 1;
  }


  $count = 0;
  foreach ($arahairpower_saved_file['link'] as $url_page) {

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
    $arahairpower_saved_file['body'][$count] = $fulltext;
    $count = $count + 1;
  }

  return $arahairpower_saved_file;
} //end of arahairpowernews function

//$arahairpower_result = arahairpower_news();

//echo $arahairpower_result['date'][1].'<br>';
//echo $arahairpower_result['link'][1].'<br>';
//echo $arahairpower_result['title'][1].'<br><br>';
//echo $arahairpower_result['body'][1].'<br>';

?>
