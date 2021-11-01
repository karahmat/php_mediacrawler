<?php

//start of change month function
function change_month_tempo($month){

    if ($month == "Januari" Or $month == "Jan") {
        $month = "-01-";}

    elseif ($month == "Februari" Or $month == "Feb") {
        $month = "-02-";}

    elseif ($month == "Maret" Or $month == "Mar") {
        $month = "-03-" ;}

    elseif ($month == "April" Or $month == "Apr") {
        $month = "-04-"; }

    elseif ($month == "Mei") {
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

//tempo
function tempo_news($search_word) {

  include("appkeyid.php");
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $tempo_saved_file = [
    'date'     => [],
    'link'     => [],
    'title'    => [],
    'body'    => []
  ];

$GCSE_SEARCH_ENGINE_ID = '017919681120236631753:x1vdggjnsq8';

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  //if ($item['link'] !== "https://www.tempo.co/" || $item['link'] !== "https://www.tempo.co/indeks") {
  $tempo_saved_file['title'][$count] = $item['htmlTitle'];
  $tempo_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
  //}
}

//getting the date and body of tempo
$count = 0;
foreach ($tempo_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  //$temp_childNodes = $dom_xpath->query('//div[@class="newsAds"]')->item(0)->textContent;
  $body = $dom_xpath->query('//div[@itemprop="articleBody"]')->item(0)->textContent;
 //itemprop="articleBody"
  //if (is_null($temp_childNodes) == false) {
  //  $body = str_replace($temp_childNodes,'',$body);
    //$dom_xpath->query('//div[@class="related"]')->item(0)->nodeValue = '';
  //}



  $date = $dom_xpath->query('//span[@id="date"]')->item(0)->nodeValue;
  //Sabtu, 27 Januari 2018 11:40 WIB
  //echo "Tempodate: ".$date;
  $date = explode(',',$date)[1];

  $date = explode(' ',$date);
  $date1 = $date[3].change_month_tempo($date[2]).$date[1];

  if ($date1 !== '') {
  $date1 = DateTime::createFromFormat('Y-m-j', $date1);
  $date1 = $date1->format('Y-m-d');  }
  
  $tempo_saved_file['body'][$count] = $body;
  $tempo_saved_file['date'][$count] = $date1;
  $count = $count+1;

} //end of foreach link

  return $tempo_saved_file;
} //end of tempo_news function bracket


?>
