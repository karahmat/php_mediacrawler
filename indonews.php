
<?php
set_time_limit(0);
?>
<html>
  <head>
    <title>News in Indonesia</title>
    <link rel="stylesheet" href="w3mobile.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-indigo.css">
  </head>
  <body>
    <form class="w3-container" method="post" action="indo_scraper.php">
    <p style="font-size:40px">
      <label class="w3-text-teal">Type in one keyword or a combination of words with + (e.g Michael+Jackson): </label><input class="w3-input w3-border w3-light-grey" type="text" name="keyword" />
    </p>

    <p style="font-size:40px">
      <label class="w3-text-teal">English word (e.g for English text): </label><input class="w3-input w3-border w3-light-grey" type="text" name="keyword_english" />
    </p>

    <p style="font-size:30px; text-align:center">

      <INPUT TYPE=SUBMIT NAME="SUBMIT" VALUE="Submit">
    </p>

    </form>

    <p style="font-size:30px; text-indent: 12px" >This scraper looks through the following news site:</p>
<br>
      <ul style="font-size:30px">
      <li>antara</li>
      <li>detik</li>
      <li>inilah</li>
      <li>jakarta post</li>
      <li>okezone</li>
      <li>kompass</li>
      <li>merdeka</li>
      <li>metrotvnews</li>
      <li>sindonews</li>
      <li>suara</li>
      <li>tribunnews</li>
      <li>cnnindo</li>
      <li>jpnn</li>
      <li>bisnisindo</li>
      <li>rmol</li>
      <li>Tempo</li>
      <li>Jawapos</li>
      <li>Liputan6</li>
      <li>Kumparan</li>   
      <li>Kompasiana</li>
    </ul>

    <p style="font-size:30px; margin-left: 12px; margin-right: 10px">It extracts the date, title and body of the news that contains your keyword.
      So you do not have to visit the individual websites separately. The following news websites have been excluded: Indopos, Republika</p>

    </body>
</html>
