<?php

function change_month_republika($month){

    if ($month == "Jan") {
        $month = "-01-";}

    elseif ($month == "Feb") {
        $month = "-02-";}

    elseif ($month == "Mar") {
        $month = "-03-" ;}

    elseif ($month == "Apr") {
        $month = "-04-"; }

    elseif ($month == "May") {
        $month = "-05-"; }

    elseif ($month == "Jun") {
        $month = "-06-"; }

    elseif ($month == "Jul") {
        $month = "-07-"; }

    elseif ($month == "Agu" or $month == "Aug") {
        $month = "-08-"; }

    elseif ($month == "Sep") {
        $month = "-09-";  }

    elseif ($month == "Oct") {
        $month = "-10-"; }

    elseif ($month == "Nov") {
        $month = "-11-"; }

    elseif ($month == "Dec") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function


//republika
function republika_news($search_word) {

//$postfield = 'search='.$search_word.'&page=1';
$postfield = 'datestart=&dateend=&q='.$search_word.'&sort-type=terbaru&offset=0';
$url_page = 'https://republika.co.id/search/'.$search_word;

$curl = curl_init();
//curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt( $curl, CURLOPT_URL, $url_page );
curl_setopt($curl, CURLOPT_POSTFIELDS, $postfield);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
//curl_setopt($curl, data, 'search=singapore&page=2');
//curl_setopt($curl, compressed, TRUE);
curl_setopt( $curl, CURLOPT_AUTOREFERER, TRUE );
curl_setopt( $curl, CURLOPT_HEADER, 0 );
curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, TRUE );

$page = curl_exec($curl);

if(curl_errno($curl)) // check for execution errors
{
	echo 'Scraper error: ' . curl_error($curl);
}

curl_close($curl);




//echo '<pre>'.htmlspecialchars($page).'</pre>';

//$page2=htmlspecialchars($page);
$html = '<html><body>'.$page.'</body></html>';
//$html = fetch_http_file_contents($html);
//print_r($html);

$republika_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

$dom = new domDocument;
libxml_use_internal_errors(true);
/*** load the html into the object ***/
$dom->loadHTML($html);
$dom_xpath = new DOMXpath($dom);

$article_boxes = $dom_xpath->query('//div[@class="txt_subkanal txt_index"]/h2/a');

$count = 0;
foreach ($article_boxes as $article_box) {
	$link = $article_box->getAttribute('href');
	$title_link = $article_box->nodeValue;

	$republika_saved_file['title'][$count] = $title_link;
	$republika_saved_file['link'][$count] = $link;
	$count = $count + 1;
}

$dates = $dom_xpath->query('//div[@class="txt_subkanal txt_index"]/h6');
$count = 0;
foreach ($dates as $date) {
  $date_value = explode(' ',$date->nodeValue);
	$date1 = $date_value[3].change_month_republika($date_value[2]).$date_value[1];

  $republika_saved_file['date'][$count] = $date1;
	$count = $count + 1;
}

//going to each article
$count = 0;
foreach ($republika_saved_file['link'] as $url_page) {
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  $paras = $dom_xpath->query("//div[@class='artikel']/p");

  $fulltext = '';
  foreach ($paras as $para) {

    $fulltext = $fulltext.'<br>'.$para->nodeValue;
  }

  $republika_saved_file['body'][$count] = $fulltext;
  $count = $count + 1;
}

return $republika_saved_file;


} //end of republika_news function


?>
