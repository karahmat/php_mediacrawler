
<html>
<head>
  <title>News in Indonesia</title>

  <style>
  table {width: 90%; margin-left: 8px; margin-right: 8px;}
  th, td {padding: 10px; text-alight:left;}
  </style>

</head>

<body>
<h1>Here are your results</h1>
<!-- <p><button onclick="sortTable()">Sort by date</button></p> -->

<?php


set_time_limit(0);
date_default_timezone_set("Asia/Jakarta");
require_once 'google-api-php-client-2.2.0/vendor/autoload.php';

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






include('bisnisindo.php');
//include('liputan6.php');
//include('bisnisindo.php');
//include('bisnisindo.php');
include('cnnindo.php');


if ($_POST["keyword"] !== "") {

$searchword = $_POST["keyword"];

  if ($_POST["keyword_english"] !== "") {
    $searchword_english = $_POST["keyword"];
  }
  else {
    $searchword_english = $_POST["keyword_english"];
  }

$bisnisindo_saved_file = bisnisindo_news($searchword);
$bisnisindo_saved_file = array_transpose($bisnisindo_saved_file);

//$liputan6_saved_file = liputan6_news($searchword);
//$bisnisindo_saved_file = bisnisindo_news($searchword);
//$bisnisindo_saved_file = bisnisindo_news($searchword);
$cnnindo_saved_file = cnnindo_news($searchword);
$cnnindo_saved_file = array_transpose($cnnindo_saved_file);

//merging all the arrays
$bisnisindo_saved_file = array_merge($bisnisindo_saved_file, $cnnindo_saved_file);


  //Method1: sorting the array using the usort function and a "callback that you define"
  function method1($a,$b)
  {
    return ($b['date'] <= $a['date']) ? -1 : 1;
  }
  usort($bisnisindo_saved_file, "method1");
  //print_r($bisnisindo_saved_file);




echo "
<table border='1' id='resultsTable'>
<tr>
  <td>date</td>
  <td>link</td>
  <td>title</td>
  <td>body</td>
</tr>
";

for ($x = 0; $x < count($bisnisindo_saved_file); $x++) {

  echo "<tr>";
    echo "<td>".$bisnisindo_saved_file[$x]['date'].'</td>';
    echo "<td><a href='".$bisnisindo_saved_file[$x]['link']."'>".$bisnisindo_saved_file[$x]['link'].'</a></td>';
    echo "<td>".$bisnisindo_saved_file[$x]['title'].'</td>';
    echo "<td>".$bisnisindo_saved_file[$x]['body'].'</td>';
  echo "</tr>";

}

/*
for ($x = 0; $x <= count($liputan6_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$liputan6_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$liputan6_saved_file['link'][$x]."'>".$liputan6_saved_file['link'][$x].'</a></td>';
    echo "<td>".$liputan6_saved_file['title'][$x].'</td>';
    echo "<td>".$liputan6_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

for ($x = 0; $x <= count($bisnisindo_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$bisnisindo_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$bisnisindo_saved_file['link'][$x]."'>".$bisnisindo_saved_file['link'][$x].'</a></td>';
    echo "<td>".$bisnisindo_saved_file['title'][$x].'</td>';
    echo "<td>".$bisnisindo_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

for ($x = 0; $x <= count($bisnisindo_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$bisnisindo_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$bisnisindo_saved_file['link'][$x]."'>".$bisnisindo_saved_file['link'][$x].'</a></td>';
    echo "<td>".$bisnisindo_saved_file['title'][$x].'</td>';
    echo "<td>".$bisnisindo_saved_file['body'][$x].'</td>';
  echo "</tr>";
}
*/

echo "</table>";

}

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
 //sortTable();
 </script>




</body>
</html>
