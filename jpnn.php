<?php

//start of change month function
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

//jpnn
function jpnn_news($search_word) {
  include("appkeyid.php"); 
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $jpnn_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];

$GCSE_SEARCH_ENGINE_ID = '007045958695197488767:xg1mcgijipg';

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $jpnn_saved_file['title'][$count] = $item['htmlTitle'];
  $jpnn_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of jpnn
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

  $paras = $dom_xpath->query('//div[@itemprop="articleBody"]/p');

  $body = '';

  foreach ($paras as $para) {
    $body .= $para->nodeValue." ";
      }

  //$pages = $dom_xpath->query('//li[@class=""]/a');

  $jpnn_saved_file['body'][$count] = $body;


  $date = $dom_xpath->query('//span[@class="date-publish"]')->item(0)->textContent;
  //Senin, 16 April 2018 &ndash; 23:55 WIB
  $date = explode(',',$date)[1];
  $date = explode(' ',$date);
  $date1 = $date[3].change_month_jpnn($date[2]).$date[1];

  if ($date1 !== '') {
  $date1 = DateTime::createFromFormat('Y-m-j', $date1);
  $date1 = $date1->format('Y-m-d');  }


  $jpnn_saved_file['date'][$count] = $date1;

  $count = $count + 1;



} // end of foreach paras

  return $jpnn_saved_file;
} //end of jpnn_news function bracket


?>
