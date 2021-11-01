<?php

function change_month_sindonews($month){

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


function sindonews_news($search_word) {
//initialising the variable
$sindonews_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//sindonews news
$count = 0;
for ($i = 0; $i <= 0; $i++) {

  $page_no = $i*12;
  $url = "https://search.sindonews.com/search/".$page_no."?type=artikel&q=".$search_word;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $articles = $dom_xpath->query('//div[@class="news-content"]');
  $msg_error = $articles[0]->textContent;

 if ($msg_error != "Data tidak ditemukan. Silahkan masukkan kata kunci yang lain.") {

  foreach ($articles as $article) {
        $link = $article->getElementsByTagName("a")->item(0)->getAttribute('href');
        $title = $article->getElementsByTagName("a")->item(0)->nodeValue;

        $span_nodes = $article->getElementsByTagName('div');

        foreach ($span_nodes as $span_node) {
          $date_node = $span_node->getAttribute("class");
          if (strpos($date_node, "news-date") !== false) {

            $date = $span_node->nodeValue;
            //echo 'Date: '.$date;
            #Kamis, 20 Juli 2017 - 05:01 WIB


             $date = explode(',', $date)[1];
             $date = explode(' ',$date);
             $date1 = $date[3].change_month_sindonews($date[2]).$date[1];
             $date1 = date_create_from_format('Y-m-d', $date1);
             $date1 = date_format($date1, 'Y-m-d');

           }// end of if (strpos($date_node, "date") !== false)


          }
          $sindonews_saved_file['date'][$count] = $date1;
          $sindonews_saved_file['link'][$count] = $link;
          $sindonews_saved_file['title'][$count] = $title;

          $count = $count + 1;
          if ($count == 6) {break;}

          }
        }

      }



if ($msg_error != "Data tidak ditemukan. Silahkan masukkan kata kunci yang lain.") {
$count = 0;

foreach ($sindonews_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);
  $bodys = $dom_xpath->query('//div[@id="content"]');

  //$inner_div = $dom->getElementById('sindonewsdetailtext')->getElementsByTagName('div');
  if (is_null($bodys) == FALSE) {
  $body = $bodys->item(0)->nodeValue;

  $sindonews_saved_file['body'][$count] = $body;
  $count = $count + 1;
  } // end of if
}
}


  return $sindonews_saved_file;
} //end of sindonewsnews function


?>
