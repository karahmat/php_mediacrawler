<?php

function cnnindo_news2($search_word) {
//initialising the variable
$cnnindo_saved_file = [];

//cnnindo news
  $url = 'https://www.cnnindonesia.com/search/?query='.$search_word;
  $html = fetch_http_file_contents($url);

  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);

  //$articles = $dom->getElementsByTagName("article");

  $articles = $dom_xpath->query('//article[count(@*)=0]');
  //$dates= $dom_xpath->query('//span[@class="date"]');

  $count = 0;
  foreach ($articles as $article) {

        if ($article->getElementsByTagName("a")->item(0) != null) {
        $link = $article->getElementsByTagName("a")->item(0)->getAttribute('href');
        $title_link = $article->getElementsByTagName("a")->item(0)->nodeValue;
        //echo $title_link."<br>";
        $cnnindo_saved_file[$count]['title'] = $title_link;
        $cnnindo_saved_file[$count]['link'] = $link;
        $count =$count + 1;
        }
        //if ($count == 6) {break;}
  }



$count = 0;
foreach ($cnnindo_saved_file['link'] as $url_page) {
  //echo 'Page: '.$url_page.'<br>';
  $html = fetch_http_file_contents($url_page);
  /*** a new dom object ***/
  $dom = new domDocument;
  libxml_use_internal_errors(true);
  /*** load the html into the object ***/
  $dom->loadHTML($html);
  $dom_xpath = new DOMXpath($dom);
  //$inner_div = $dom->getElementById('cnnindodetailtext')->getElementsByTagName('div');

  $body = $dom->getElementById('detikdetailtext')->nodeValue;

  $cnnindo_saved_file[$count]['body'] = $body;

  $date2 = $dom_xpath->query('//div[@class="date"]')->item(0)->nodeValue;
  //echo $url_page.'<br>';
  //echo $date2.'<br>';
  #Wishnugroho Akbar, CNN Indonesia | Sabtu, 31/03/2018 23:44 WIB
  $date1 = explode(',',$date2)[2];
  #31/03/2018 17:17 WIB
  //echo $date1.'<br>';
  $date1 = explode(' ',$date1)[1];

  if (strlen($date1) > 0) {
  //echo 'Date :'.$date1;
  $date1 = DateTime::createFromFormat('j/m/Y', $date1);
  //echo 'Date2 :'.$date1;
  $date1 = $date1->format('Y-m-d');  }

  $cnnindo_saved_file[$count]['date'] = $date1;



  $count = $count + 1;
} //end of foreach ($cnnindo_saved_file['link'] as $url_page)

  return $cnnindo_saved_file;
} //end of cnnindonews function

?>
