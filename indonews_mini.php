
<html>
  <head>
    <title>News in Indonesia</title>
    <link rel="stylesheet" href="w3mobile.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-indigo.css">
  </head>
  <body>
    <form class="w3-container" method="post" action="indo_scraper_mini.php">
    <p style="font-size:25px">
      <label class="w3-text-teal">Type in one keyword or a combination of words with + (e.g Michael+Jackson): </label><input class="w3-input w3-border w3-light-grey" type="text" name="keyword" />
    </p>

    <p style="font-size:25px">
      <label class="w3-text-teal">English word (e.g for English text): </label><input class="w3-input w3-border w3-light-grey" type="text" name="keyword_english" />
    </p>

    <p style="font-size:25px; text-align:center">

      <INPUT TYPE=SUBMIT NAME="SUBMIT" VALUE="Submit">
    </p>

    </form>

    <p>This scraper looks through the following news site:<br>
      <ul>
      <li>antara</li>
      <li>jakartapost</li>
      <li>kompass</li>
    </ul>
    </p>

    </body>
</html>
