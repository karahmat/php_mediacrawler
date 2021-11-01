
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





include('cnnindo.php');
include('liputan6.php');
include('kumparan.php');
include('kompasiana.php');



if ($_POST["keyword"] !== "") {

$searchword = $_POST["keyword"];

  if ($_POST["keyword_english"] !== "") {
    $searchword_english = $_POST["keyword"];
  }
  else {
    $searchword_english = $_POST["keyword_english"];
  }

$cnnindo_saved_file = cnnindo_news($searchword);
//$liputan6_saved_file = liputan6_news($searchword);
$kumparan_saved_file = kumparan_news($searchword);
//$cnnindo_saved_file = array_merge_recursive($cnnindo_saved_file, $kumparan_saved_file);

$kompasiana_saved_file = kompasiana_news($searchword);
$cnnindo_saved_file = array_merge_recursive($cnnindo_saved_file, $kumparan_saved_file, $kompasiana_saved_file);



$servername = "localhost";
$username = "Azzie";
$password = "meinBlumen1984";
$dbname = "Indonews";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// sql to delete a record
$sql = "DELETE FROM Indonews";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}



echo "<table border='1' id='resultsTable'>";

echo "
<tr>
  <td>date</td>
  <td>link</td>
  <td>title</td>
  <td>body</td>
</tr>
";


for ($x = 0; $x < count($cnnindo_saved_file['link']); $x++) {


  $link1 = $conn->real_escape_string(urlencode($cnnindo_saved_file['link'][$x]));
  //$link1 = 'testing';
  $title1 = $conn->real_escape_string($cnnindo_saved_file['title'][$x]);

  //echo $link1."<br>";


  echo "<tr>";
    echo "<td>".$cnnindo_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$cnnindo_saved_file['link'][$x]."'>".$cnnindo_saved_file['link'][$x].'</a></td>';
    echo "<td>".$cnnindo_saved_file['title'][$x].'</td>';
    echo "<td>".$cnnindo_saved_file['body'][$x].'</td>';
  echo "</tr>";


  //$link1 = urlencode($cnnindo_saved_file['link'][$x]);
  $date1 = $cnnindo_saved_file['date'][$x];
  $body1 = $conn->real_escape_string($cnnindo_saved_file['body'][$x]);

  $sql = "INSERT INTO Indonews (news_date, link, title, body) VALUES ('$date1','$link1','$title1','$body1')";


  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error."<br>";
  }

}

$conn->close();



/*
for ($x = 0; $x <= count($liputan6_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$liputan6_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$liputan6_saved_file['link'][$x]."'>".$liputan6_saved_file['link'][$x].'</a></td>';
    echo "<td>".$liputan6_saved_file['title'][$x].'</td>';
    echo "<td>".$liputan6_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

for ($x = 0; $x <= count($kumparan_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$kumparan_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$kumparan_saved_file['link'][$x]."'>".$kumparan_saved_file['link'][$x].'</a></td>';
    echo "<td>".$kumparan_saved_file['title'][$x].'</td>';
    echo "<td>".$kumparan_saved_file['body'][$x].'</td>';
  echo "</tr>";
}

for ($x = 0; $x <= count($kompasiana_saved_file['link']); $x++) {
  echo "<tr>";
    echo "<td>".$kompasiana_saved_file['date'][$x].'</td>';
    echo "<td><a href='".$kompasiana_saved_file['link'][$x]."'>".$kompasiana_saved_file['link'][$x].'</a></td>';
    echo "<td>".$kompasiana_saved_file['title'][$x].'</td>';
    echo "<td>".$kompasiana_saved_file['body'][$x].'</td>';
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
 sortTable();
 </script>




</body>
</html>
