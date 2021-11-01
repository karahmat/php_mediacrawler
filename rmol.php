<?php

//start of change month function
function change_month_rmol($month){

    if ($month == "JANUARI" Or $month == "Jan") {
        $month = "-01-";}

    elseif ($month == "FEBRUARI" Or $month == "Feb") {
        $month = "-02-";}

    elseif ($month == "MARET" Or $month == "Mar") {
        $month = "-03-" ;}

    elseif ($month == "APRIL" Or $month == "Apr") {
        $month = "-04-"; }

    elseif ($month == "MEI") {
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

//rmol
function rmol_news($search_word) {

  include("appkeyid.php");
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $rmol_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];

$GCSE_SEARCH_ENGINE_ID = '007291239372666293912:7xxlt64hjae';

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $rmol_saved_file['title'][$count] = $item['htmlTitle'];
  $rmol_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of rmol
$count = 0;
foreach ($rmol_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = file_get_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $body = $dom_xpath->query('//div[@class="content"]/p')->item(0)->nodeValue;



  $date = $dom_xpath->query('//em[@class="news-post-info half-bottom"]')->item(0)->nodeValue;
  //MINGGU, 28 JULI 2019 | 00:31 WIB  |
  $date = explode(' ',$date);
  $date1 = $date[3].change_month_rmol($date[2]).$date[1];

  $rmol_saved_file['body'][$count] = $body;
  $rmol_saved_file['date'][$count] = $date1;
  $count = $count+1;

} //end of foreach link

  return $rmol_saved_file;
} //end of rmol_news function bracket


?>
