<?php

function change_month_kompas($month){

    if ($month == "Jan") {
        $month = "01";}

    elseif ($month == "Feb") {
        $month = "02";}

    elseif ($month == "Mar") {
        $month = "03" ;}

    elseif ($month == "Apr") {
        $month = "04"; }

    elseif ($month == "May") {
        $month = "05"; }

    elseif ($month == "Jun") {
        $month = "06"; }

    elseif ($month == "Jul") {
        $month = "07"; }

    elseif ($month == "Aug") {
        $month = "08"; }

    elseif ($month == "Sep") {
        $month = "09";  }

    elseif ($month == "Oct") {
        $month = "10"; }

    elseif ($month == "Nov") {
        $month = "11"; }

    elseif ($month == "Dec") {
        $month = "12"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function

//Kompas
function kompas_news($search_word) {

  require_once 'google-api-php-client-2.2.0/vendor/autoload.php';
  $executionStartTime = microtime(true);  
  include("appkeyid.php");  
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $kompas_saved_file = [
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


$GCSE_SEARCH_ENGINE_ID = $indo_news_sites[0];

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $kompas_saved_file['title'][$count] = $item['htmlTitle'];
  $kompas_saved_file['link'][$count] = $item['link'];



  $count = $count + 1;
}

//getting the date and body of Kompas
$count = 0;
foreach ($kompas_saved_file['link'] as $url_page) {
  #echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  if ($dom_xpath->query('//div[@class="read__content"]')->item(0) != null) {
  $paras = $dom_xpath->query('//div[@class="read__content"]')->item(0)->getElementsByTagName("p");

  $body = '';
  foreach ($paras as $para) {
        $body .= $para->nodeValue.' ';
    }//end of foreach articles

  $date = $dom_xpath->query('//div[@class="read__time"]')->item(0)->nodeValue;
  $date = explode(' ',$date)[2];

  $date = str_replace(',','',$date);
  $day = explode('/',$date)[0];
  $month = explode('/',$date)[1];
  $year = explode('/',$date)[2];



  if ($date !== '') {
  $date = $day.'/'.change_month_kompas($month).'/'.$year;
  $date = DateTime::createFromFormat('j/m/Y', $date);
  $date = $date->format('Y-m-d');  }



  $kompas_saved_file['body'][$count] = $body;
  $kompas_saved_file['date'][$count] = $date;}
  $count = $count+1;

} //end of foreach link

  return $kompas_saved_file;
} //end of kompas_news function bracket



?>
