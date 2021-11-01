<?php

function change_month_cnbc($month){

    if ($month == "January") {
        $month = "-01-";}

    elseif ($month == "February") {
        $month = "-02-";}

    elseif ($month == "March") {
        $month = "-03-" ;}

    elseif ($month == "April") {
        $month = "-04-"; }

    elseif ($month == "May") {
        $month = "-05-"; }

    elseif ($month == "June") {
        $month = "-06-"; }

    elseif ($month == "July") {
        $month = "-07-"; }

    elseif ($month == "August") {
        $month = "-08-"; }

    elseif ($month == "September") {
        $month = "-09-";  }

    elseif ($month == "October") {
        $month = "-10-"; }

    elseif ($month == "November") {
        $month = "-11-"; }

    elseif ($month == "December") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function

function cnbcindo_news($search_word) {

//initialising the variable
$cnbcindo_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//cnbcindo news

  $url = 'https://www.cnbcindonesia.com/search?query='.$search_word;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $articles = $dom->getElementsByTagName("article");
  //echo $articles[0]->getElementsByTagName("a")->item(0)->getAttribute('href');

  //$articles = $dom_xpath->query('//article[count(@*)=0]');
  //$dates= $dom_xpath->query('//span[@class="date"]');

  $count = 0;
  foreach ($articles as $article) {

        if ($article->getElementsByTagName("a")->item(0) != null) {
        $link = $article->getElementsByTagName("a")->item(0)->getAttribute('href');
        //echo $link."<br>";
        $title_link = $article->getElementsByTagName("a")->item(0)->nodeValue;
        //echo $title_link."<br>";
        $cnbcindo_saved_file['title'][$count] = $title_link;
        $cnbcindo_saved_file['link'][$count] = $link;
        $count =$count + 1;
        }
        //if ($count == 6) {break;}
  }



$count = 0;
foreach ($cnbcindo_saved_file['link'] as $url_page) {
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);
  //$inner_div = $dom->getElementById('cnbcindodetailtext')->getElementsByTagName('div');

  $body = $dom_xpath->query('//div[@class="detail_text"]')->item(0)->textContent;

  $cnbcindo_saved_file['body'][$count] = $body;

  $date2 = $dom_xpath->query('//div[@class="date"]')->item(0)->nodeValue;
  //echo $url_page.'<br>';
  //echo $date2.'<br>';
  #17 October 2018 20:25
  $date1 = explode(' ',$date2);
  #31/03/2018 17:17 WIB
  //echo $date1.'<br>';
  $date1 = $date1[2].change_month_cnbc($date1[1]).$date1[0];

  if (strlen($date1) > 0) {
  //echo 'Date :'.$date1;
  $date1 = date_create_from_format('Y-m-d', $date1);
  $date1 = date_format($date1, 'Y-m-d');

  }

  $cnbcindo_saved_file['date'][$count] = $date1;



  $count = $count + 1;
} //end of foreach ($cnbcindo_saved_file['link'] as $url_page)

  return $cnbcindo_saved_file;
} //end of cnbcindonews function

?>
