
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
require_once "Mail.php";
require_once "Mail/mime.php";

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
  $antara_saved_file = array_transpose($antara_saved_file);

  echo "Detik <br>";
  include('detik.php');
  $detik_saved_file = detik_news($searchword);
  $detik_saved_file = array_transpose($detik_saved_file);

  echo "Kompas <br>";
  include('kompass.php');
  $kompas_saved_file = kompas_news($searchword);
  $kompas_saved_file = array_transpose($kompas_saved_file);

  echo "JPNN <br>";
  include('jpnn.php');
  $jpnn_saved_file = jpnn_news($searchword);
  $jpnn_saved_file = array_transpose($jpnn_saved_file);

  echo "Jakarta Post <br>";
  include('jakartapost.php');
  $jakartapost_saved_file = jakartapost_news($searchword_english);
  $jakartapost_saved_file = array_transpose($jakartapost_saved_file);

  echo "Merdeka <br>";
  include('merdeka.php');
  $merdeka_saved_file = merdeka_news($searchword);
  $merdeka_saved_file = array_transpose($merdeka_saved_file);


  echo "Metrotvnews <br>";
  include('metrotvnews.php');
  $metrotvnews_saved_file = metrotvnews_news($searchword);
  $metrotvnews_saved_file = array_transpose($metrotvnews_saved_file);


  echo "Sindonews <br>";
  include('sindonews.php');
  $sindonews_saved_file = sindonews_news($searchword);
  $sindonews_saved_file = array_transpose($sindonews_saved_file);

  echo "Suara <br>";
  include('suara.php');
  $suara_saved_file = suara_news($searchword);
  $suara_saved_file = array_transpose($suara_saved_file);


  echo "Tribunnews <br>";
  include('tribunnews.php');
  $tribunnews_saved_file = tribunnews_news($searchword);
  $tribunnews_saved_file = array_transpose($tribunnews_saved_file);


  echo "CNN Indo <br>";
  include('cnnindo.php');
  $cnnindo_saved_file = cnnindo_news($searchword);
  $cnnindo_saved_file = array_transpose($cnnindo_saved_file);

  echo "CNBC Indo <br>";
  include('cnbcindo.php');
  $cnbcindo_saved_file = cnbcindo_news($searchword);
  $cnbcindo_saved_file = array_transpose($cnbcindo_saved_file);

  echo "Jawapos <br>";
  include('jawapos.php');
  $jawapos_saved_file = jawapos_news($searchword);
  $jawapos_saved_file = array_transpose($jawapos_saved_file);


  echo "RMOL <br>";
  include('rmol.php');
  $rmol_saved_file = rmol_news($searchword);
  $rmol_saved_file = array_transpose($rmol_saved_file);


  echo "Bisnis Indo <br>";
  include('bisnisindo.php');
  $bisnisindo_saved_file = bisnisindo_news($searchword);
  $bisnisindo_saved_file = array_transpose($bisnisindo_saved_file);


  echo "Okezone <br>";
  include('okezone.php');
  $okezone_saved_file = okezone_news($searchword);
  $okezone_saved_file = array_transpose($okezone_saved_file);


  echo "Tempo <br>";
  include('tempo.php');
  $tempo_saved_file = tempo_news($searchword);
  $tempo_saved_file = array_transpose($tempo_saved_file);


  echo "Inilah <br>";
  include('inilah.php');
  $inilah_saved_file = inilah_news($searchword);
  $inilah_saved_file = array_transpose($inilah_saved_file);


  echo "Kumparan <br>";
  include('kumparan.php');
  $kumparan_saved_file = kumparan_news($searchword);
  $kumparan_saved_file = array_transpose($kumparan_saved_file);


  echo "Kompasiana <br>";
  include('kompasiana.php');
  $kompasiana_saved_file = kompasiana_news($searchword);
  $kompasiana_saved_file = array_transpose($kompasiana_saved_file);

  echo "Gatra <br>";
  include('gatra.php');
  $gatra_saved_file = gatra_news($searchword);
  $gatra_saved_file = array_transpose($gatra_saved_file);

  echo "Republika <br>";
  include('republika.php');
  $republika_saved_file = republika_news($searchword);
  $republika_saved_file = array_transpose($republika_saved_file);

  //echo "chappy <br>";
  //include('chappy.php');
  //$chappy_saved_file = chappy_news($searchword);
  //$chappy_saved_file = array_transpose($chappy_saved_file);

  echo "arahkita <br>";
  include('arahkita.php');
  $arahkita_saved_file = arahkita_news($searchword);
  $arahkita_saved_file = array_transpose($arahkita_saved_file);

  echo "arahairpower <br>";
  include('arahairpower.php');
  $arahairpower_saved_file = arahairpower_news();
  $arahairpower_saved_file = array_transpose($arahairpower_saved_file);

  $all_saved_file = [];

  $all_saved_file = array_merge(
  $antara_saved_file,
  $detik_saved_file,
  $kompas_saved_file,
  $jpnn_saved_file,
  $jakartapost_saved_file,
  $merdeka_saved_file,
  $metrotvnews_saved_file,
  $sindonews_saved_file,
  $suara_saved_file,
  $tribunnews_saved_file,
  $cnnindo_saved_file,
  $cnbcindo_saved_file,
  $jpnn_saved_file,
  $jawapos_saved_file,
  $rmol_saved_file,
  $bisnisindo_saved_file,
  $okezone_saved_file,
  $tempo_saved_file,
  $inilah_saved_file,
  $kumparan_saved_file,
  $kompasiana_saved_file,
  $gatra_saved_file,
  $republika_saved_file,
  $arahkita_saved_file,
  $arahairpower_saved_file);


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
<html>
<body>
<h1>Indonesian news for today</h1>
<table border='1' id='resultsTable'>
<tr>
  <td>date</td>
  <td>link</td>
  <td>title</td>
  <td>body</td>
</tr>
";

$today = date("Y-m-d");

//LINKING TO DATABASE LOCAL
//$servername = "localhost";
//$username = "root";
//$password = "gw_6Ki8p,h8*";
//$dbname = "IndoNews";


//LINKING TO DATABASE VPS
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


for ($x = 0; $x < count($all_saved_file); $x++) {

  $link1 = urlencode($all_saved_file[$x]['link']);

  $sql = "SELECT link FROM Indonews WHERE link='$link1' ";
  $result = $conn->query($sql);

  if ($all_saved_file[$x]['date'] == $today and $result->num_rows == 0) {

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

  //Placing records into Database
  $link1 = $conn->real_escape_string(urlencode($all_saved_file[$x]['link']));
  $title1 = $conn->real_escape_string($all_saved_file[$x]['title']);
  $date1 = $all_saved_file[$x]['date'];
  $body1 = $conn->real_escape_string($all_saved_file[$x]['body']);

  $sql = "INSERT INTO Indonews (news_date, link, title, body) VALUES ('$date1','$link1','$title1','$body1')";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error."<br>";
  }



  } //end of if ($all_saved_file[$x]['date'] == $today)


} //end of for-loop through all the all_saved_file

$conn->close();

echo "Search Complete! <br>";
echo "</table>";

$email_msg .= "</table>";
$email_msg .= "Search Complete - courtesy of Khairul Azman! <br>";
$email_msg .= "</body></html>";

$mime = new Mail_mime();
        $mime->setHTMLBody($email_msg);

        $mimeparams=array();

        $mimeparams['text_encoding']="8bit";
        $mimeparams['text_charset']="UTF-8";
        $mimeparams['html_charset']="UTF-8";
        $mimeparams['head_charset']="UTF-8";

        $email_msg = $mime->get($mimeparams);

$from = '<khairul.azman.rahmat@gmail.com>';
$subject = 'Indonesian News - update every two hours';
$recipient = array("azman.sing.emb@gmail.com","xhsingaporeemb@gmail.com","Yeeler17@gmail.com", "tan.wenyi90@gmail.com", "jansonccq@gmail.com","matthewchan.th@gmail.com");
$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com', //tried also without ssl:// or tls://
        'port' => '465', //tried also 578
        'auth' => true,
        'username' => 'khairul.azman.rahmat@gmail.com',
        'password' => 'nftldczqaqimrvgq' //or code provided by google 2-step-verification
    ));

//sending the emails
for ($x = 0; $x < count($recipient); $x++) {

$headers = array(
    'From' => $from,
    'To' => $recipient[$x],
    'Subject' => $subject,
    'MIME-Version' => 1,
    'Content-type' => 'text/html;charset=iso-8859-1'
);

$headers = $mime->headers($headers);

$mail = $smtp->send($recipient[$x], $headers, $email_msg);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    echo('<p>Message successfully sent!</p>');
}

}

// Always set content-type when sending HTML email
/*
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "Reply-To: The Sender <webmaster@thekazrah.com>\r\n";
$headers .= "Return-Path: The Sender <webmaster@thekazrah.com>\r\n";
$headers .= 'From: <webmaster@thekazrah.com>' . "\r\n";
  $headers .= "Organization: Sender Organization\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;

// send email

mail("khairul.azman.rahmat@gmail.com","Indonesian News - update every 2 hours",$email_msg, $headers);
mail("caixihao@gmail.com","Indonesian News - update every 2 hours",$email_msg, $headers);
mail("Yeeler17@gmail.com","Indonesian News - update every 2 hours",$email_msg, $headers);
mail("tan.wenyi90@gmail.com","Indonesian News - update every 2 hours",$email_msg, $headers);
mail("yiyime2@gmail.com","Indonesian News - update every 2 hours",$email_msg, $headers);
mail("matthewchan.th@gmail.com","Indonesian News - update every 2 hours",$email_msg, $headers);
*/

 ?>




</body>
</html>
