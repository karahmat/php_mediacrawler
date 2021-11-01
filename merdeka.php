<?php

//start of change month function
function change_month_merdeka($month){

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


//merdeka
function merdeka_news($search_word) {

  //configure your thing
  include("appkeyid.php");
  $searchword = 'Singapura';
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $merdeka_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];

  $indo_news_sites = [
  '018212539862037696382:-xa61bkyvao',
  'partner-pub-7486139053367666:4965051114',
  '001561947424278099921:7qnaw_9r2rq',
  '009693617939879592379:wxvqc64bh3s',
  '008086164163598071346:djhxpzyiqw4',
  '007685728690098461931:2lpamdk7yne'];


$GCSE_SEARCH_ENGINE_ID = $indo_news_sites[2];

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $merdeka_saved_file['title'][$count] = $item['htmlTitle'];
  $merdeka_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of merdeka
$count = 0;
foreach ($merdeka_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $paras_temp = $dom_xpath->query('//div[@class="mdk-body-paragraph"]');

  $body = '';
  if (($paras_temp->length) > 0) {
  $paras = $paras_temp->item(0)->getElementsByTagName("p");

  foreach ($paras as $para) {
        $body .= $para->nodeValue.'<br>';
    }//end of foreach articles
  }


  $date = $dom_xpath->query('//span[@class="date-post"]')->item(0)->nodeValue;
  #Rabu, 30 November 2016 12:56
  $date = explode(',',$date)[1];
  $date = explode(' ',$date);
  $date1 = $date[3].change_month_merdeka($date[2]).$date[1];

  if ($date1 !== '') {
  $date1 = DateTime::createFromFormat('Y-m-j', $date1);
  $date1 = $date1->format('Y-m-d');  }


  $merdeka_saved_file['body'][$count] = $body;
  $merdeka_saved_file['date'][$count] = $date1;
  $count = $count+1;

} //end of foreach link

  return $merdeka_saved_file;
} //end of merdeka_news function bracket


?>
