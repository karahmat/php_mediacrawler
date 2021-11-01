<?php

//start of change month function
function change_month_jawapos($month){

    if ($month == "Januari" Or $month == "JAN") {
        $month = "-01-";}

    elseif ($month == "Februari" Or $month == "FEB") {
        $month = "-02-";}

    elseif ($month == "Maret" Or $month == "Mar") {
        $month = "-03-" ;}

    elseif ($month == "April" Or $month == "Apr") {
        $month = "-04-"; }

    elseif ($month == "Mei" Or $month == "May") {
        $month = "-05-"; }

    elseif ($month == "Juni" Or $month == "Jun") {
        $month = "-06-"; }

    elseif ($month == "Juli" Or $month == "Jul") {
        $month = "-07-"; }

    elseif ($month == "Agustus" Or $month == "Aug") {
        $month = "-08-"; }

    elseif ($month == "September" Or $month == "Sep") {
        $month = "-09-";  }

    elseif ($month == "Oktober" Or $month == "Okt") {
        $month = "-10-"; }

    elseif ($month == "November" Or $month == "Nov") {
        $month = "-11-"; }

    elseif ($month == "Desember" Or $month == "Des") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function

//jawapos
function jawapos_news($search_word) {
  include("appkeyid.php");
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $jawapos_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];

$GCSE_SEARCH_ENGINE_ID = '012209424901670165781:fruzhiutzca';

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $jawapos_saved_file['title'][$count] = $item['htmlTitle'];
  $jawapos_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of jawapos
$count = 0;
foreach ($jawapos_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $paras = $dom_xpath->query("//span[@class='s1']");

 if (($paras_temp->length) > 0) {
  $fulltext = '';

  foreach ($paras as $para) {
    $fulltext = $fulltext.'<br>'.$para->nodeValue;
    }
  }
  else {
    $fulltext = '';
    $paras = $dom_xpath->query("//div[@class='content']/p");
    foreach ($paras as $para) {
      $fulltext = $fulltext.'<br>'.$para->nodeValue;
      }

  }

  $date = $dom_xpath->query('//div[@class="time"]')->item(0)->nodeValue;
  $date = explode(',',$date)[0];
  //8 Juli 2019, 17:31:12 WIB
  $date = explode(' ',$date);
  $date1 = $date[2].change_month_jawapos($date[1]).$date[0];
  if ($date1 !== '') {
  $date1 = DateTime::createFromFormat('Y-m-j', $date1);
  $date1 = $date1->format('Y-m-d');  }



  $jawapos_saved_file['body'][$count] = $fulltext;
  $jawapos_saved_file['date'][$count] = $date1;
  $count = $count+1;

} //end of foreach link

  return $jawapos_saved_file;
} //end of jawapos_news function bracket


?>
