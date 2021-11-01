<?php

function change_month($month){

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

    elseif ($month == "Agu" or $month == "Aug") {
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


function detik_news($search_word) {
//initialising the variable
$detik_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//Detik news
$count = 0;
for ($i = 1; $i <= 1; $i++) {
  $url = "https://www.detik.com/search/searchnews?query=".$search_word."&sortby=time&page=".$i;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);

  $articles = $dom->getElementsByTagName('article');

  foreach ($articles as $article) {
        $link = $article->getElementsByTagName("a")->item(0)->getAttribute('href');
        $title_link = $article->getElementsByTagName("h2")->item(0)->nodeValue;

        $span_nodes = $article->getElementsByTagName('span');


        foreach ($span_nodes as $span_node) {
          $date_node = $span_node->getAttribute("class");
          if (strpos($date_node, "date") !== false) {
            $date = $span_node->nodeValue;
            //echo 'Date: '.$date;
            #snippet = link.getElementsByTagName("p").getText()
            if ($date !== " ") {
                //$date = $article->getElementsByTagName("span[class = date]")->nodeValue;
                #Selasa, 25 Jul 2017 11:32 WIB   -
                $date = explode(',', $date)[1];
                #25 Jul 2017 11:32 WIB
                $date = explode(' ', $date);
                $date1 = $date[3].change_month($date[2]).$date[1];
                $date1 = date_create_from_format('Y-m-d', $date1);
                $date1 = date_format($date1, 'Y-m-d');

            } else {
                $date1 = '';}



          }

        }

        $detik_saved_file['date'][$count] = $date1;
        $detik_saved_file['link'][$count] = $link;
        $detik_saved_file['title'][$count] = $title_link;

        $count = $count + 1;
      }


}

$count = 0;
foreach ($detik_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  //$inner_div = $dom->getElementById('detikdetailtext')->getElementsByTagName('div');
  if (is_null($dom->getElementById('detikdetailtext')) == FALSE) {
  $inner_divs = $dom->getElementById('detikdetailtext')->getElementsByTagName('div');

  while ($inner_divs->length) {
    $node = $inner_divs->item(0);
    $node->parentNode->removeChild($node);
  }

  $body = $dom->getElementById('detikdetailtext')->nodeValue;

  $detik_saved_file['body'][$count] = $body;
  $count = $count + 1;
  } // end of if
}

  return $detik_saved_file;
} //end of detiknews function

?>
