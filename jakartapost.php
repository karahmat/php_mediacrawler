<?php

//start of change month function
function change_month_jakartapost($month){

    if ($month == "January") {
        $month = "-01-";}

    elseif ($month == "February") {
        $month = "-02-";}

    elseif ($month == "March") {
        $month = "-03-" ;}

    elseif ($month == "April") {
        $month = "-04-"; }

    elseif ($month == "May") {
        $month = "-05-"; }

    elseif ($month == "June") {
        $month = "-06-"; }

    elseif ($month == "July") {
        $month = "-07-"; }

    elseif ($month == "August") {
        $month = "-08-"; }

    elseif ($month == "September") {
        $month = "-09-";  }

    elseif ($month == "October") {
        $month = "-10-"; }

    elseif ($month == "November") {
        $month = "-11-"; }

    elseif ($month == "December") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function


//jakartapost
function jakartapost_news($search_word) {
  include("appkeyid.php");
  //configure your thing  
  $client = new Google_Client();
  $client->setApplicationName("customsearch");
  $client->setDeveloperKey($AppKeyID);

  $jakartapost_saved_file = [
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


$GCSE_SEARCH_ENGINE_ID = $indo_news_sites[5];

$service = new Google_Service_Customsearch($client);
$optParams = array("cx"=>$GCSE_SEARCH_ENGINE_ID, "sort"=>"Date");
$results = $service->cse->listCse($search_word, $optParams);

$count = 0;
foreach($results->getItems() as $k=>$item){
  $jakartapost_saved_file['title'][$count] = $item['htmlTitle'];
  $jakartapost_saved_file['link'][$count] = $item['link'];
  $count = $count + 1;
}

//getting the date and body of jakartapost
$count = 0;
foreach ($jakartapost_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $paras_temp = $dom_xpath->query('//div[@class="show-define-text"]');

  $body = '';
  if (($paras_temp->length) > 0) {
  $paras = $paras_temp->item(0)->getElementsByTagName("p");

  foreach ($paras as $para) {
        $body .= $para->nodeValue.' ';
    }//end of foreach articles
  }


  $date = $dom_xpath->query('//span[@class="day"]')->item(0)->nodeValue;
  $date1 = '';

  if (substr_count($date, ',') == 2) {
  #Thu, August 31, 2017
  $month_day = explode(',',$date)[1];
  $year = explode(',',$date)[2];
  $month = explode(' ',$month_day)[1];
  $day = explode(' ',$month_day)[2];
  $date1 = $year.change_month_jakartapost($month).$day;

  //echo "Jpost - The date is: ".$date1;
  //$date1 = date_create_from_format('Y-m-d', $date1);
  //$date1 = date_format($date1, 'Y-m-d');


  }
  elseif (substr_count($date, ',') == 1) {
 //Sat, September 2 2017
  $m_d_y = explode(',',$date)[1];
  $date1 = explode(' ',$m_d_y);
  $date1 = $date1[3].change_month_jakartapost($date1[1]).$date1[2];

  //echo "Jpost - The date is: ".$date1."<br>";
  //$date1 = date_create_from_format('Y-m-d', $date1);
  //$date1 = date_format($date1, 'Y-m-d');

  }

  $jakartapost_saved_file['body'][$count] = $body;


  $jakartapost_saved_file['date'][$count] = $date1;
  $count = $count+1;

} //end of foreach link

  return $jakartapost_saved_file;
} //end of jakartapost_news function bracket


?>
