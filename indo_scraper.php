
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

/*
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
*/
function fetch_http_file_contents( $url ) {

  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

  $data = curl_exec( $ch );
  curl_close( $ch );

  return $data;

}

if ($_POST["keyword"] !== "") {

$searchword = $_POST["keyword"];

  if ($_POST["keyword_english"] !== "") {
    $searchword_english = $_POST["keyword"];
  }
  else {
    $searchword_english = $_POST["keyword_english"];
  }


echo "<table border='1' id='resultsTable'>";

echo "
<tr>
  <th>Date</th>
  <th>Link</th>
  <th>Title</th>
  <th>Body</th>
</tr>
";

echo "Antara <br>";
include('antara.php');
$antara_saved_file = antara_news($searchword);
for ($x = 0; $x <= count($antara_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$antara_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$antara_saved_file['link'][$x]."'>".$antara_saved_file['link'][$x].'</a></td>';
    echo "<td>".$antara_saved_file['title'][$x].'</td>';
    echo "<td>".$antara_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Detik <br>";
include('detik.php');
$detik_saved_file = detik_news($searchword);
for ($x = 0; $x <= count($detik_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$detik_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$detik_saved_file['link'][$x]."'>".$detik_saved_file['link'][$x].'</a></td>';
    echo "<td>".$detik_saved_file['title'][$x].'</td>';
    echo "<td>".$detik_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Jakarta Post <br>";
include('jakartapost.php');
$jakartapost_saved_file = jakartapost_news($searchword_english);
for ($x = 0; $x <= count($jakartapost_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$jakartapost_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$jakartapost_saved_file['link'][$x]."'>".$jakartapost_saved_file['link'][$x].'</a></td>';
    echo "<td>".$jakartapost_saved_file['title'][$x].'</td>';
    echo "<td>".$jakartapost_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Kompas <br>";
include('kompass.php');
$kompas_saved_file = kompas_news($searchword);
for ($x = 0; $x <= count($kompas_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$kompas_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$kompas_saved_file['link'][$x]."'>".$kompas_saved_file['link'][$x].'</a></td>';
    echo "<td>".$kompas_saved_file['title'][$x].'</td>';
    echo "<td>".$kompas_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Merdeka <br>";
include('merdeka.php');
$merdeka_saved_file = merdeka_news($searchword);
for ($x = 0; $x <= count($merdeka_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$merdeka_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$merdeka_saved_file['link'][$x]."'>".$merdeka_saved_file['link'][$x].'</a></td>';
    echo "<td>".$merdeka_saved_file['title'][$x].'</td>';
    echo "<td>".$merdeka_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Metrotvnews <br>";
include('metrotvnews.php');
$metrotvnews_saved_file = metrotvnews_news($searchword);
for ($x = 0; $x <= count($metrotvnews_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$metrotvnews_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$metrotvnews_saved_file['link'][$x]."'>".$metrotvnews_saved_file['link'][$x].'</a></td>';
    echo "<td>".$metrotvnews_saved_file['title'][$x].'</td>';
    echo "<td>".$metrotvnews_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Sindonews <br>";
include('sindonews.php');
$sindonews_saved_file = sindonews_news($searchword);
for ($x = 0; $x <= count($sindonews_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$sindonews_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$sindonews_saved_file['link'][$x]."'>".$sindonews_saved_file['link'][$x].'</a></td>';
    echo "<td>".$sindonews_saved_file['title'][$x].'</td>';
    echo "<td>".$sindonews_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Suara <br>";
include('suara.php');
$suara_saved_file = suara_news($searchword);
for ($x = 0; $x <= count($suara_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$suara_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$suara_saved_file['link'][$x]."'>".$suara_saved_file['link'][$x].'</a></td>';
    echo "<td>".$suara_saved_file['title'][$x].'</td>';
    echo "<td>".$suara_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Tribunnews <br>";
include('tribunnews.php');
$tribunnews_saved_file = tribunnews_news($searchword);
for ($x = 0; $x <= count($tribunnews_saved_file['link']); $x++) {
  echo "<tr>";
  echo "<td>".$tribunnews_saved_file['date'][$x].'</td>';
  echo "<td><a href='".$tribunnews_saved_file['link'][$x]."'>".$tribunnews_saved_file['link'][$x].'</a></td>';
  echo "<td>".$tribunnews_saved_file['title'][$x].'</td>';
  echo "<td>".$tribunnews_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "CNN Indo <br>";
include('cnnindo.php');
$cnnindo_saved_file = cnnindo_news($searchword);
for ($x = 0; $x <= count($cnnindo_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$cnnindo_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$cnnindo_saved_file['link'][$x]."'>".$cnnindo_saved_file['link'][$x].'</a></td>';
    echo "<td>".$cnnindo_saved_file['title'][$x].'</td>';
    echo "<td>".$cnnindo_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "CNBC Indo <br>";
include('cnbcindo.php');
$cnbcindo_saved_file = cnbcindo_news($searchword);
for ($x = 0; $x <= count($cnbcindo_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$cnbcindo_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$cnbcindo_saved_file['link'][$x]."'>".$cnbcindo_saved_file['link'][$x].'</a></td>';
    echo "<td>".$cnbcindo_saved_file['title'][$x].'</td>';
    echo "<td>".$cnbcindo_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "JPNN <br>";
include('jpnn.php');
$jpnn_saved_file = jpnn_news($searchword);
for ($x = 0; $x <= count($jpnn_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$jpnn_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$jpnn_saved_file['link'][$x]."'>".$jpnn_saved_file['link'][$x].'</a></td>';
    echo "<td>".$jpnn_saved_file['title'][$x].'</td>';
    echo "<td>".$jpnn_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Jawapos <br>";
include('jawapos.php');
$jawapos_saved_file = jawapos_news($searchword);
for ($x = 0; $x <= count($jawapos_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$jawapos_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$jawapos_saved_file['link'][$x]."'>".$jawapos_saved_file['link'][$x].'</a></td>';
    echo "<td>".$jawapos_saved_file['title'][$x].'</td>';
    echo "<td>".$jawapos_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "RMOL <br>";
include('rmol.php');
$rmol_saved_file = rmol_news($searchword);
for ($x = 0; $x <= count($rmol_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$rmol_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$rmol_saved_file['link'][$x]."'>".$rmol_saved_file['link'][$x].'</a></td>';
    echo "<td>".$rmol_saved_file['title'][$x].'</td>';
    echo "<td>".$rmol_saved_file['body'][$x].'</td>';
  echo "</tr>";
}


echo "Bisnis Indo <br>";
include('bisnisindo.php');
$bisnisindo_saved_file = bisnisindo_news($searchword);
for ($x = 0; $x <= count($bisnisindo_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$bisnisindo_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$bisnisindo_saved_file['link'][$x]."'>".$bisnisindo_saved_file['link'][$x].'</a></td>';
    echo "<td>".$bisnisindo_saved_file['title'][$x].'</td>';
    echo "<td>".$bisnisindo_saved_file['body'][$x].'</td>';
  echo "</tr>";
}


echo "Okezone <br>";
include('okezone.php');
$okezone_saved_file = okezone_news($searchword);
for ($x = 0; $x <= count($okezone_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$okezone_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$okezone_saved_file['link'][$x]."'>".$okezone_saved_file['link'][$x].'</a></td>';
    echo "<td>".$okezone_saved_file['title'][$x].'</td>';
    echo "<td>".$okezone_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Tempo <br>";
include('tempo.php');
$tempo_saved_file = tempo_news($searchword);
for ($x = 0; $x <= count($tempo_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$tempo_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$tempo_saved_file['link'][$x]."'>".$tempo_saved_file['link'][$x].'</a></td>';
    echo "<td>".$tempo_saved_file['title'][$x].'</td>';
    echo "<td>".$tempo_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Inilah <br>";
include('inilah.php');
$inilah_saved_file = inilah_news($searchword);
for ($x = 0; $x <= count($inilah_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$inilah_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$inilah_saved_file['link'][$x]."'>".$inilah_saved_file['link'][$x].'</a></td>';
    echo "<td>".$inilah_saved_file['title'][$x].'</td>';
    echo "<td>".$inilah_saved_file['body'][$x].'</td>';
  echo "</tr>";
}


echo "Liputan6 <br>";
include('liputan6.php');
$liputan6_saved_file = liputan6_news($searchword);
for ($x = 0; $x <= count($liputan6_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$liputan6_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$liputan6_saved_file['link'][$x]."'>".$liputan6_saved_file['link'][$x].'</a></td>';
    echo "<td>".$liputan6_saved_file['title'][$x].'</td>';
    echo "<td>".$liputan6_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Kumparan <br>";
include('kumparan.php');
$kumparan_saved_file = kumparan_news($searchword);
for ($x = 0; $x <= count($kumparan_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$kumparan_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$kumparan_saved_file['link'][$x]."'>".$kumparan_saved_file['link'][$x].'</a></td>';
    echo "<td>".$kumparan_saved_file['title'][$x].'</td>';
    echo "<td>".$kumparan_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Kompasiana <br>";
include('kompasiana.php');
$kompasiana_saved_file = kompasiana_news($searchword);
for ($x = 0; $x <= count($kompasiana_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$kompasiana_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$kompasiana_saved_file['link'][$x]."'>".$kompasiana_saved_file['link'][$x].'</a></td>';
    echo "<td>".$kompasiana_saved_file['title'][$x].'</td>';
    echo "<td>".$kompasiana_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "gatra <br>";
include('gatra.php');
$gatra_saved_file = gatra_news($searchword);
for ($x = 0; $x <= count($gatra_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$gatra_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$gatra_saved_file['link'][$x]."'>".$gatra_saved_file['link'][$x].'</a></td>';
    echo "<td>".$gatra_saved_file['title'][$x].'</td>';
    echo "<td>".$gatra_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "republika <br>";
include('republika.php');
$republika_saved_file = republika_news($searchword);
for ($x = 0; $x <= count($republika_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$republika_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$republika_saved_file['link'][$x]."'>".$republika_saved_file['link'][$x].'</a></td>';
    echo "<td>".$republika_saved_file['title'][$x].'</td>';
    echo "<td>".$republika_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "chappy <br>";
include('chappy.php');
$chappy_saved_file = chappy_news($searchword);
for ($x = 0; $x <= count($chappy_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$chappy_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$chappy_saved_file['link'][$x]."'>".$chappy_saved_file['link'][$x].'</a></td>';
    echo "<td>".$chappy_saved_file['title'][$x].'</td>';
    echo "<td>".$chappy_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "arahkita <br>";
include('arahkita.php');
$arahkita_saved_file = arahkita_news($searchword);
for ($x = 0; $x <= count($arahkita_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$arahkita_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$arahkita_saved_file['link'][$x]."'>".$arahkita_saved_file['link'][$x].'</a></td>';
    echo "<td>".$arahkita_saved_file['title'][$x].'</td>';
    echo "<td>".$arahkita_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "arahairpower <br>";
include('arahairpower.php');
$arahairpower_saved_file = arahairpower_news();
for ($x = 0; $x <= count($arahairpower_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$arahairpower_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$arahairpower_saved_file['link'][$x]."'>".$arahairpower_saved_file['link'][$x].'</a></td>';
    echo "<td>".$arahairpower_saved_file['title'][$x].'</td>';
    echo "<td>".$arahairpower_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

echo "Search Complete! <br>";
echo "</table>";

}

$executionEndTime = microtime(true);

//The result will be in seconds and milliseconds.
$seconds = $executionEndTime - $executionStartTime;

//Print it out
echo "This script took $seconds to execute.";

 ?>

<script>
  function sortTable() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("resultsTable");
    switching = true;
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
      //start by saying: no switching is done:
      switching = false;
      rows = table.getElementsByTagName("TR");
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[0];
        y = rows[i + 1].getElementsByTagName("TD")[0];
        //check if the two rows should switch place:
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
      }
    }
  }
  </script>


</body>
</html>
