<?php
function change_month_okezone($month){

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


//okezone
function okezone_news($search_word) {

  include("appkeyid.php");
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $okezone_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];




$GCSE_SEARCH_ENGINE_ID = '008455228336814040957:4gwqinsieym';

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $okezone_saved_file['title'][$count] = $item['htmlTitle'];
  $okezone_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of okezone
$count = 0;
foreach ($okezone_saved_file['link'] as $url_page) {
  //echo 'OkezonePage: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  if ($dom_xpath->query('//div[@id="contentx"]')->item(0) != null) {
  $paras = $dom_xpath->query('//div[@id="contentx"]')->item(0)->getElementsByTagName("p");

  $body = '';
  foreach ($paras as $para) {
        $body .= $para->nodeValue.' ';
    }//end of foreach articles

  $date = $dom_xpath->query('//div[@class="namerep"]')->item(0)->childNodes[5]->nodeValue;
  #echo 'length '.$date->length;
  #echo 'Date :'.$date;

  #$date = explode('Jurnalis',$date)[1];
  #echo 'Date :'.$date;
  #Sabtu 09 Desember 2017, 21:08 WIB
  $date = explode(' ',$date);

  $date_year = str_replace(',','',$date[3]);
  #echo 'Date1 :'.$date[3];

  $date1 = $date_year.change_month_okezone($date[2]).$date[1];
  #echo 'DateOkezone :'.$date1;

  if ($date1 !== '') {
    $date1 = date_create_from_format('Y-m-d', $date1);
    $date1 = date_format($date1, 'Y-m-d');}

  $okezone_saved_file['body'][$count] = $body;
  $okezone_saved_file['date'][$count] = $date1;}
  $count = $count+1;

} //end of foreach link

  return $okezone_saved_file;
} //end of okezone_news function bracket



?>
