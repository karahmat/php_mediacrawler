<?php

function change_month_tninews($month){

    if ($month == "Jan") {
        $month = "-01-";}

    elseif ($month == "Feb") {
        $month = "-02-";}

    elseif ($month == "Mar") {
        $month = "-03-" ;}

    elseif ($month == "Apr") {
        $month = "-04-"; }

    elseif ($month == "Mei") {
        $month = "-05-"; }

    elseif ($month == "Jun") {
        $month = "-06-"; }

    elseif ($month == "Jul") {
        $month = "-07-"; }

    elseif ($month == "Aug") {
        $month = "-08-"; }

    elseif ($month == "Sep") {
        $month = "-09-";  }

    elseif ($month == "Okt") {
        $month = "-10-"; }

    elseif ($month == "Nov") {
        $month = "-11-"; }

    elseif ($month == "Des") {
        $month = "-12-"; }

    else {
        $month = $month; }

    return $month;
} // end of change month function


//tninews
function tninews_news($search_word) {

//$postfield = 'search='.$search_word.'&page=1';
$postfield = 'q='.$search_word;
$url_page = 'https://tni.mil.id/news.html';

$curl = curl_init($url_page);
//curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postfield);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
//curl_setopt($curl, data, 'search=singapore&page=2');
//curl_setopt($curl, compressed, TRUE);

$page = curl_exec($curl);
echo $page;

if(curl_errno($curl)) // check for execution errors
{
	echo 'Scraper error: ' . curl_error($curl);
	exit;
}

curl_close($curl);
//echo '<pre>'.htmlspecialchars($page).'</pre>';

//$page2=htmlspecialchars($page);
$html = '<html><body>'.$page.'</body></html>';
//$html = fetch_http_file_contents($html);

$tninews_saved_file = [
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

	$tninews_saved_file['title'][$count] = $title_link;
	$tninews_saved_file['link'][$count] = $link;
	$count = $count + 1;
}

$dates = $dom_xpath->query('//div[@class="txt_subkanal txt_index"]/h6');
$count = 0;
foreach ($dates as $date) {
  $date_value = explode(' ',$date->nodeValue);
	$date1 = $date_value[3].change_month_tninews($date_value[2]).$date_value[1];

  $tninews_saved_file['date'][$count] = $date1;
	$count = $count + 1;
}

//going to each article
$count = 0;
foreach ($tninews_saved_file['link'] as $url_page) {
  $html = file_get_contents($url_page);
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

  $tninews_saved_file['body'][$count] = $fulltext;
  $count = $count + 1;
}

return $tninews_saved_file;


} //end of tninews_news function

$tninews_result = tninews_news('Singapura');


?>
