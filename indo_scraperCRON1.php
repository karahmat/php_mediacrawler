
<html>
<head>
  <title>News in Indonesia</title>
  <style>
  table {width: 90%; margin-left: 8px; margin-right: 8px;}
  th, td {padding: 10px; text-alight:left; font-size: 18px;}
  button {font-size: 20px;}
  </style>

</head>


<body>

<h1>Here are your results</h1>
<p><button onclick="sortTable()">Sort by date</button></p>

<?php

set_time_limit(0);
date_default_timezone_set("Asia/Jakarta");
require_once 'google-api-php-client-2.2.0/vendor/autoload.php';
$executionStartTime = microtime(true);

function fetch_http_file_contents($url) {
  $hostname = parse_url($url, PHP_URL_HOST);
  if ($hostname == FALSE) {
    return FALSE;
  }

  $host_has_ipv6 = FALSE;
  $host_has_ipv4 = FALSE;
  $file_response = FALSE;

  $dns_records = dns_get_record($hostname, DNS_AAAA + DNS_A);

  foreach ($dns_records as $dns_record) {
    if (isset($dns_record['type'])) {
      switch ($dns_record['type']) {
        case 'AAAA':
          $host_has_ipv6 = TRUE;
          break;
        case 'A':
          $host_has_ipv4 = TRUE;
          break;
  } } }

  if ($host_has_ipv6 === TRUE) {
    $file_response = file_get_intbound_contents($url, '[0]:0');
  }
  if ($host_has_ipv4 === TRUE && $file_response == FALSE) {
    $file_response = file_get_intbound_contents($url, '0:0');
  }

  return $file_response;
}

function file_get_intbound_contents($url, $bindto_addr_family) {
  $stream_context = stream_context_create(
                      array(
                        'socket' => array(
                          'bindto' => $bindto_addr_family
                        ),
                        'http' => array(
                          'timeout'=>20,
                          'method'=>'GET'
                    ) ) );

  return file_get_contents($url, FALSE, $stream_context);
}

//transposing arrays
function array_transpose($array, $selectKey = false) {
    if (!is_array($array)) return false;
    $return = array();
    foreach($array as $key => $value) {
        if (!is_array($value)) return $array;
        if ($selectKey) {
            if (isset($value[$selectKey])) $return[] = $value[$selectKey];
        } else {
            foreach ($value as $key2 => $value2) {
                $return[$key2][$key] = $value2;
            }
        }
    }
    return $return;
}

//----------------------------------------------------------



  $searchword = "Singapura";
  $searchword_english = "Singapore";

  echo "Antara <br>";
  include('antara.php');
  $antara_saved_file = antara_news($searchword);

  echo "Detik <br>";
  include('detik.php');
  $detik_saved_file = detik_news($searchword);

  echo "Jakarta Post <br>";
  include('jakartapost.php');
  $jakartapost_saved_file = jakartapost_news($searchword_english);

  echo "Kompas <br>";
  include('kompass.php');
  $kompas_saved_file = kompas_news($searchword);

  echo "Merdeka <br>";
  include('merdeka.php');
  $merdeka_saved_file = merdeka_news($searchword);

  echo "Metrotvnews <br>";
  include('metrotvnews.php');
  $metrotvnews_saved_file = metrotvnews_news($searchword);

  echo "Sindonews <br>";
  include('sindonews.php');
  $sindonews_saved_file = sindonews_news($searchword);

  echo "Suara <br>";
  include('suara.php');
  $suara_saved_file = suara_news($searchword);

  echo "Tribunnews <br>";
  include('tribunnews.php');
  $tribunnews_saved_file = tribunnews_news($searchword);

  echo "CNN Indo <br>";
  include('cnnindo.php');
  $cnnindo_saved_file = cnnindo_news($searchword);

  echo "JPNN <br>";
  include('jpnn.php');
  $jpnn_saved_file = jpnn_news($searchword);

  echo "Jawapos <br>";
  include('jawapos.php');
  $jawapos_saved_file = jawapos_news($searchword);

  echo "RMOL <br>";
  include('rmol.php');
  $rmol_saved_file = rmol_news($searchword);

  echo "Bisnis Indo <br>";
  include('bisnisindo.php');
  $bisnisindo_saved_file = bisnisindo_news($searchword);

  echo "Okezone <br>";
  include('okezone.php');
  $okezone_saved_file = okezone_news($searchword);

  echo "Tempo <br>";
  include('tempo.php');
  $tempo_saved_file = tempo_news($searchword);

  echo "Inilah <br>";
  include('inilah.php');
  $inilah_saved_file = inilah_news($searchword);

  echo "Kumparan <br>";
  include('kumparan.php');
  $kumparan_saved_file = kumparan_news($searchword);

  echo "Kompasiana <br>";
  include('kompasiana.php');
  $kompasiana_saved_file = kompasiana_news($searchword);

  $all_saved_file = array_merge_recursive(
  $antara_saved_file,
  $detik_saved_file,
  $jakartapost_saved_file,
  $kompas_saved_file,
  $merdeka_saved_file,
  $metrotvnews_saved_file,
  $sindonews_saved_file,
  $suara_saved_file,
  $tribunnews_saved_file,
  $cnnindo_saved_file,
  $jpnn_saved_file,
  $jawapos_saved_file,
  $rmol_saved_file,
  $bisnisindo_saved_file,
  $okezone_saved_file,
  $tempo_saved_file,
  $inilah_saved_file,
  $kumparan_saved_file,
  $kompasiana_saved_file);

  $all_saved_file = array_transpose($all_saved_file);

    //Method1: sorting the array using the usort function and a "callback that you define"
    function method1($a,$b)
    {
      return ($b['date'] <= $a['date']) ? -1 : 1;
    }
    usort($all_saved_file, "method1");


echo "<table border='1' id='resultsTable'>";

echo "
<tr>
  <th>Date</th>
  <th>Link</th>
  <th>Title</th>
  <th>Body</th>
</tr>
";

//Preparing email message
$email_msg = "
<h1>Indonesian news for today</h1>
<table border='1' id='resultsTable'>
<tr>
  <td>date</td>
  <td>link</td>
  <td>title</td>
  <td>body</td>
</tr>
";

for ($x = 0; $x < count($all_saved_file); $x++) {

  echo "<tr>";
    echo "<td>".$all_saved_file[$x]['date'].'</td>';
    echo "<td><a href='".$all_saved_file[$x]['link']."'>".$all_saved_file[$x]['link'].'</a></td>';
    echo "<td>".$all_saved_file[$x]['title'].'</td>';
    echo "<td>".$all_saved_file[$x]['body'].'</td>';
  echo "</tr>";

  $email_msg .= "<tr>";
    $email_msg .= "<td>".$all_saved_file[$x]['date'].'</td>';
    $email_msg .= "<td><a href='".$all_saved_file[$x]['link']."'>".$all_saved_file[$x]['link'].'</a></td>';
    $email_msg .= "<td>".$all_saved_file[$x]['title'].'</td>';
    $email_msg .= "<td>".$all_saved_file[$x]['body'].'</td>';
  $email_msg .= "</tr>";

} //end of for-loop through all the all_saved_file


echo "Search Complete! <br>";
echo "</table>";

$email_msg .= "Search Complete - courtesy of Khairul Azman! <br>";
$email_msg .= "</table>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <webmaster@thekazrah.com>' . "\r\n";
// send email
mail("khairul.azman.rahmat@gmail.com","Indo News",$email_msg, $headers);
mail("caixihao@gmail.com","Indo News",$email_msg, $headers);
mail("Yeeler17@gmail.com","Indo News",$email_msg, $headers);
mail("tan.wenyi90@gmail.com","Indo News",$email_msg, $headers);

$executionEndTime = microtime(true);

//The result will be in seconds and milliseconds.
$seconds = $executionEndTime - $executionStartTime;

//Print it out
echo "This script took $seconds to execute.";

 ?>




</body>
</html>
