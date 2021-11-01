<?php

//start of change month function
function change_month_metrotvnews($month){

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

    elseif ($month == "Desember" Or $month == "Dec") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function


//metrotvnews
function metrotvnews_news($search_word) {

  //configure your thing
  include("appkeyid.php");
  $searchword = 'Singapura';
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $metrotvnews_saved_file = [
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


$GCSE_SEARCH_ENGINE_ID = $indo_news_sites[4];

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $metrotvnews_saved_file['title'][$count] = $item['htmlTitle'];
  $metrotvnews_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of metrotvnews
$count = 0;
foreach ($metrotvnews_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $temp_childNodes = $dom_xpath->query('//div[@class="related"]')->item(0)->nodeValue;
  $body = $dom_xpath->query('//div[@class="tru"]')->item(0)->nodeValue;

  if (is_null($temp_childNodes) == false) {
    $body = str_replace($temp_childNodes,'',$body);
    //$dom_xpath->query('//div[@class="related"]')->item(0)->nodeValue = '';
  }

  $metrotvnews_saved_file['body'][$count] = $body;

  //echo $url_page.' :'.$body."<br>";


  $date_temp = $dom_xpath->query('//div[@class="reg"]')->item(0)->nodeValue;
  #Krisna Octavianus &nbsp;&nbsp; &bull; &nbsp;&nbsp; 24 Juli 2017 14:48 WIB

  $date = explode(' ',$date_temp);
  $date1 = '';

  if (substr_count($date_temp, '-') == 2) {


    for ($k=0; $k<count($date); $k++) {
      if (substr_count($date[$k], '-') == 2)  {
        $date1 = $date[$k];
        $date1 = date_create_from_format('Y-m-d', $date1);
        $date1 = date_format($date1, 'Y-m-d');



      }
    }

  }

  elseif (substr_count($date_temp, '-') !== 2) {
      for ($k=0; $k<count($date); $k++) {
      if (is_numeric($date[$k]) == TRUE) {

        $date1 = $date[$k+2].change_month_metrotvnews($date[$k+1]).$date[$k];
        $date1 = date_create_from_format('Y-m-d', $date1);
        $date1 = date_format($date1, 'Y-m-d');
        break;
      }
  } //end of for ($k=0; $k<count($date); $k++)
}

  $metrotvnews_saved_file['date'][$count] = $date1;
  $count = $count+1;

} //end of foreach link

  return $metrotvnews_saved_file;
} //end of metrotvnews_news function bracket

?>
