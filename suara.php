<?php
function change_month_suara($month){

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


function suara_news($search_word) {
//initialising the variable
$suara_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//suara news
$count = 0;
for ($i = 0; $i <= 0; $i++) {
  $url = "http://www.suara.com/search/".$search_word."/page--".$i;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $articles = $dom_xpath->query('//a[@class="ellipsis2"]');


  foreach ($articles as $article) {
        $link = $article->getAttribute('href');
        #echo 'link '.$link;

        $title = $article->nodeValue;

        $span_nodes = $article->getElementsByTagName('div');

        //http://www.suara.com/news/2015/01/05/165809/angkut-1400-mobil-mewah-kapal-kargo-singapura-terbalik
          $date = str_replace('https://www.suara.com/','',$link);
          $date = explode("/",$date);
          $date1 = $date[1].'-'.$date[2].'-'.$date[3];
          #echo 'suara '.$date[1].'-'.$date[2].'-'.$date[3];
          $date1 = date_create_from_format('Y-m-d', $date1);
          $date1 = date_format($date1, 'Y-m-d');


          $suara_saved_file['date'][$count] = $date1;
          $suara_saved_file['link'][$count] = $link;
          $suara_saved_file['title'][$count] = $title;

          $count = $count + 1;
          if ($count == 6) {break;}

          }


      }




$count = 0;
foreach ($suara_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  if ($dom->getElementsByTagName('article')->item(0) != null) {
  $paras = $dom->getElementsByTagName('article')->item(0)->getElementsByTagName('p');

  for ($n=0;$n<$dom_xpath->query('//div[@class="baca-juga"]')->length; $n++) {
    $dom_xpath->query('//div[@class="baca-juga"]')->item($n)->nodeValue = "";
    //$node->parentNode->removeChild($node);
  }



  $body = '';
  foreach ($paras as $para){
    $body .= $para->nodeValue.' ';

  }

  $suara_saved_file['body'][$count] = $body;}
  $count = $count + 1;

}

  return $suara_saved_file;
} //end of suaranews function

?>
