<?php

function gatra_news($search_word) {
//initialising the variable
$gatra_saved_file = [
  'date'     => [],
  'link'     => [],
  'title'    => [],
  'body'    => []
];

//gatra news
  $url = 'https://www.gatra.com/search?cari='.$search_word;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  //$articles = $dom->getElementsByTagName("article");

  $articles = $dom_xpath->query('//div[@class="article-big"]/div[@class="article-content"]');
  //$dates= $dom_xpath->query('//span[@class="date"]');

  $count = 0;
  foreach ($articles as $article) {

        $link = $article->getElementsByTagName("a")->item(0)->getAttribute('href');
        $title_link = $article->getElementsByTagName("a")->item(0)->nodeValue;
        //echo $title_link."<br>";
        $gatra_saved_file['title'][$count] = $title_link;
        $gatra_saved_file['link'][$count] = $link;
        $count =$count + 1;
        //if ($count == 6) {break;}
  }

  $count = 0;
  foreach ($gatra_saved_file['link'] as $url_page) {
    $html = fetch_http_file_contents($url_page);
    /*** a new dom object ***/
    $dom = new domDocument;
    libxml_use_internal_errors(true);
    /*** load the html into the object ***/
    $dom->loadHTML($html);
    $dom_xpath = new DOMXpath($dom);
    //$inner_div = $dom->getElementById('gatradetailtext')->getElementsByTagName('div');

    //$paras = $dom_xpath->query('//div[@class="column9"]/p');

    $body = $dom_xpath->query('//div[@class="column9"]')->item(0)->textContent;

    //foreach ($paras as $para) {
      //$body .= $para->item(0)->nodeValue." ";
        //}

    $gatra_saved_file['body'][$count] = $body;

    $dom_xpath = new DOMXpath($dom);
    $date2 = $dom_xpath->query('//div[@class="a-content"]/div[@class="meta"]')->item(0)->nodeValue;
    //07-03-2019 08:15
    $date3 = explode(' ',$date2)[0];
    #07-03-2019
    $date1 = str_replace('-','/',$date3);
    #07/03/2019
    if (strlen($date1) > 0) {
    $date1 = DateTime::createFromFormat('j/m/Y', $date1);
    //echo 'Date2 :'.$date1;
    $date1 = $date1->format('Y-m-d');  }

    $gatra_saved_file['date'][$count] = $date1;



    $count = $count + 1;
  } //end of foreach ($gatra_saved_file['link'] as $url_page)




  return $gatra_saved_file;
} //end of gatraews function

?>
