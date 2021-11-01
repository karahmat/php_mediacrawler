<?php

function change_month_bisnisindo($month){

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


function bisnisindo_news($search_word) {
//initialising the variable
$bisnisindo_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//bisnisindo news

  $url = "http://search.bisnis.com/?q=".$search_word;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);



  $articles = $dom_xpath->query('//div[@class="col-sm-8"]/h2/a');

  $count = 0;
  foreach ($articles as $article) {
        $link = $article->getAttribute('href');
        //echo $link."<br>";
        $bisnisindo_saved_file['link'][$count] = $link;
        $title = $article->textContent;
        //echo $title."<br>";
        $bisnisindo_saved_file['title'][$count] = $title;
        $count = $count + 1;
        }


  $articles = $dom_xpath->query('//div[@class="col-sm-8"]/div[@class="wrapper-description"]/div[@class="channel"]/div[@class="date"]');

  $count = 0;
  foreach ($articles as $article) {
        $date = $article->textContent;
        $date = str_replace("WIB","",$date);
        $date = trim($date);
        //16 Februari 2021 16:25
        $date2 = explode(' ', $date);
        //$date = explode('>',$date)[1];
        //$date = explode(' ',$date);
        $date1 = $date2[2].change_month_bisnisindo($date2[1]).$date2[0];

        if ($date1 !== '') {
        $date1 = DateTime::createFromFormat('Y-m-j', $date1);
        $date1 = $date1->format('Y-m-d'); }

        $bisnisindo_saved_file['date'][$count] = $date1;
        $count = $count + 1;
    }


$count = 0;
foreach ($bisnisindo_saved_file['link'] as $url_page) {
  //echo 'Bisnis Indonesia Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $paras = $dom_xpath->query('//div[@class="col-sm-10"]/p');

  $body = '';

  foreach ($paras as $para) {
    $body .= $para->nodeValue."<br>";
      }

  $bisnisindo_saved_file['body'][$count] = $body;
  $count = $count + 1;



} // end of foreach paras


  return $bisnisindo_saved_file;
} //end of bisnisindonews function


?>
