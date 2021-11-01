<?php

//start of change month function
function change_month_liputansix($month){

    if ($month == "Jan" Or $month == "JAN") {
        $month = "-01-";}

    elseif ($month == "Feb" Or $month == "FEB") {
        $month = "-02-";}

    elseif ($month == "MARET" Or $month == "Mar") {
        $month = "-03-" ;}

    elseif ($month == "APRIL" Or $month == "Apr") {
        $month = "-04-"; }

    elseif ($month == "Mei") {
        $month = "-05-"; }

    elseif ($month == "JUNI" Or $month == "Jun") {
        $month = "-06-"; }

    elseif ($month == "JULI" Or $month == "Jul") {
        $month = "-07-"; }

    elseif ($month == "AGUSTUS" Or $month == "Aug") {
        $month = "-08-"; }

    elseif ($month == "SEPTEMBER" Or $month == "Sep") {
        $month = "-09-";  }

    elseif ($month == "OKTOBER" Or $month == "Okt") {
        $month = "-10-"; }

    elseif ($month == "NOVEMBER" Or $month == "Nov") {
        $month = "-11-"; }

    elseif ($month == "DESEMBER" Or $month == "Des") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function

//liputansix
function liputansix_news($search_word) {

  include("appkeyid.php");
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $liputansix_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];

$GCSE_SEARCH_ENGINE_ID = '89N4-SLvQ_qVO8SopWxueQ';
//https://www.google-analytics.com/cx/api.js?experiment=89N4-SLvQ_qVO8SopWxueQ
$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $liputansix_saved_file['title'][$count] = $item['htmlTitle'];
  $liputansix_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of liputansix
$count = 0;
foreach ($liputansix_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $temp_childNodes = $dom_xpath->query('//div[@class="col-lg-5"]')->item(0)->textContent;
  $body = $dom_xpath->query('//div[@class="paragraph-article-detail"]')->item(0)->textContent;

  if (is_null($temp_childNodes) == false) {
    $body = str_replace($temp_childNodes,'',$body);
    //$dom_xpath->query('//div[@class="related"]')->item(0)->nodeValue = '';
  }



  $date = $dom_xpath->query('//div[@class="time-publiser-by"]')->item(0)->nodeValue;
  $date = explode(',',$date)[1];
//19 JAN 2018 10:32 | EDITOR : ARIES WAHYUDIANTO
  $date = explode(' ',$date);
  $date1 = $date[3].change_month_liputansix($date[2]).$date[1];

  $liputansix_saved_file['body'][$count] = $body;
  $liputansix_saved_file['date'][$count] = $date1;
  $count = $count+1;

} //end of foreach link

  return $liputansix_saved_file;
} //end of liputansix_news function bracket


?>
