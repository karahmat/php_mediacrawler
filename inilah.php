<?php

//start of change month function
function change_month_inilah($month){

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
        $month = ''; }

    return $month;
} // end of change month function


//inilah
function inilah_news($search_word) {
  include("appkeyid.php");
  //configure your thing  
  $searchword = 'Singapura';
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $inilah_saved_file = [
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


$GCSE_SEARCH_ENGINE_ID = $indo_news_sites[3];

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $inilah_saved_file['title'][$count] = $item['htmlTitle'];
  $inilah_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of inilah
$count = 0;
foreach ($inilah_saved_file['link'] as $url_page) {
  //echo 'Inilah Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $paras = $dom_xpath->query('//div[@class="inc---detail-content"]/p');

  $body = '';

  foreach ($paras as $para) {
    $body .= $para->nodeValue." ";
      }


    $date_temp1 = $dom_xpath->query('//div[@class="author-time"]')->item(0)->nodeValue;
    $date_temp1 = ltrim($date_temp1);
    $date_temp1 = explode(' ',$date_temp1);
    $date1 = $date_temp1[3].change_month_inilah($date_temp1[2]).$date_temp1[1];

    $date1 = date_create_from_format('Y-m-d', $date1);
    $date1 = date_format($date1, 'Y-m-d');
    $inilah_saved_file['date'][$count] = $date1;



  $inilah_saved_file['body'][$count] = $body;
  $count = $count+1;

} //end of foreach link

  return $inilah_saved_file;
} //end of inilah_news function bracket


?>
