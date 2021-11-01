<?php

function change_month_antara($month){

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


function antara_news($search_word) {
//initialising the variable
$antara_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//antara news
$count = 0;

  $url = "https://www.antaranews.com/search/".$search_word;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $articles = $dom_xpath->query('//article[@class="simple-post simple-big clearfix"]');


  foreach ($articles as $article) {
        $link = $article->getElementsByTagName("a")->item(0)->getAttribute('href');
        //$link = "http://www.antaranews.com".$link;


        $title_temp = $article->getElementsByTagName("h3");
        if ($title_temp ->length > 1) {
          $title_link = str_replace($title_temp->item(1)->nodeValue,"",$title_temp->item(0)->nodeValue);
        }
        else {
          $title_link = $title_temp->item(0)->nodeValue;}
        $span_nodes = $article->getElementsByTagName('span')->item(0)->textContent;
        //26 Januari 2018 20:57
        if (strpos($span_nodes, "lalu") !== false) {
            $date1 = date("Y-m-d");
          } //end if
       else {
         #25 Jul 2017 11:32 WIB   -
         $date = explode(' ', $span_nodes);
         $date1 = $date[3].change_month_antara($date[2]).$date[1];
       } //end else

        //echo "Date: ".$span_nodes."<br>";
        //echo "Date: ".$date1."<br>";

        /*
        foreach ($span_nodes as $span_node) {
          $date_node = $span_node->getAttribute("class");
          if (strpos($date_node, "date") !== false) {

            $date = $span_node->nodeValue;
            //echo 'Date: '.$date;
            #snippet = link.getElementsByTagName("p").getText()
            if (strpos($date, "lalu") !== false) {
                $date1 = date("Y-m-d");
              } //end if
           else {
             #25 Jul 2017 11:32 WIB   -
             $date = explode(' ', $date);
             $date1 = $date[2].change_month_antara($date[1]).$date[0];
           } //end else
         }// end of if (strpos($date_node, "date") !== false)


       }*/
          $date1 = date_create_from_format('Y-m-d', $date1);
          $date1 = date_format($date1, 'Y-m-d');
          $antara_saved_file['date'][$count] = $date1;
          $antara_saved_file['link'][$count] = $link;
          $antara_saved_file['title'][$count] = $title_link;

          $count = $count+1;
        }







$count = 0;
foreach ($antara_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  //$inner_div = $dom->getElementById('antaradetailtext')->getElementsByTagName('div');
  //if (is_null($dom->getElementById('content_news')) == FALSE) {

  /*$inner_script = $dom->getElementById('content_news')->getElementsByTagName('script');

  while ($inner_script->length) {
    $node = $inner_script->item(0);
    $node->parentNode->removeChild($node);
  }*/
  $dom_xpath = new DOMXpath($dom);
  $articles = $dom_xpath->query('//div[@class="post-content clearfix"]');
  $body = $articles->item(0)->textContent;

  $antara_saved_file['body'][$count] = $body;
  $count = $count + 1;
  //} // end of if
}

  return $antara_saved_file;
} //end of antaranews function



?>
