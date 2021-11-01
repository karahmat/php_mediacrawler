<?php

function liputan6_news($search_word) {
//initialising the variable
$liputan6_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//liputan6 news

  //$url = "http://www.liputan6.com/search?order=latest&channel_id=&from_date=02%2F08%2F2016&to_date=02%2F09%2F2017&type=all&q=Singapura";

//https://www.liputan6.com/search?q=Singapura

  $url = "https://www.liputan6.com/search?q=".$search_word;
  echo $url;
  $html = fetch_http_file_contents($url);
  //$html = file_get_contents($url);
  /**$ch = curl_init($url);
  //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');
   curl_setopt($ch, CURLOPT_AUTOREFERER, true);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
   curl_setopt($ch, CURLOPT_VERBOSE, 1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch,  CURLOPT_COOKIESESSION, TRUE);

   //curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/search");
  $html = curl_exec($ch);
  curl_close($ch);


  /*** a new dom object ***/

  $dom = new domDocument;
  libxml_use_internal_errors(true);

  /*** load the html into the object ***/

  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);


  $links = $dom_xpath->query('//a[@class="ui--a articles--iridescent-list--text-item__title-link"]');
  $titles = $dom_xpath->query('//span[@class="articles--iridescent-list--text-item__title-link-text"]');


  $count = 0;
  foreach ($links as $link_temp) {
        $link = $link_temp->getAttribute('href');
        echo "Link: ".$link."<br>";
          $liputan6_saved_file['link'][$count] = $link;
          $count = $count + 1;
          if ($count == 10) { break;}
        }

  $count = 0;
  foreach ($titles as $title_temp) {
        $title = $title_temp->nodeValue;
        //echo "Title: ".$title."<br>";

        $liputan6_saved_file['title'][$count] = $title;
        $count = $count + 1;
        if ($count == 10) { break;}

      }






$count = 0;
foreach ($liputan6_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);
  $bodys = $dom_xpath->query('//div[@class="article-content-body__item-content"]');
  //echo $dom_xpath->query('//p[@class="baca-juga__header"]')->length;

  for ($n=0;$n<$dom_xpath->query('//p[@class="baca-juga__header"]')->length; $n++) {
    $dom_xpath->query('//p[@class="baca-juga__header"]')->item($n)->nodeValue = "";
    //$node->parentNode->removeChild($node);
  }

  for ($m=0; $m<$dom_xpath->query('//ul[@class="baca-juga__list"]')->length; $m++) {
    $dom_xpath->query('//ul[@class="baca-juga__list"]')->item($m)->nodeValue = "";
  }

  $body = $bodys->item(0)->nodeValue;

  $date = $dom_xpath->query('//time[@class="read-page--header--author__datetime updated"]')->item(0)->getAttribute('datetime');
  //echo $date."<br>";
  $date = explode(' ',$date)[0];


  $date = date_create_from_format('Y-m-d', $date);
  $date = date_format($date, 'Y-m-d');

  $liputan6_saved_file['body'][$count] = $body;
  $liputan6_saved_file['date'][$count] = $date;

  $count = $count + 1;
  } // end of if






  return $liputan6_saved_file;
} //end of liputan6news function


?>
