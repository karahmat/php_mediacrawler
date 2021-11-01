# Media crawler using PHP

## Introduction

This is a simple media crawler that crawls through over 20 Indonesian news media outlets. It is built purely using PHP. No PHP framework has been used. 

If you are interested to use this app, please visit [here](http://www.thekazrah.com/php_scrape/indonews.php)

## File structure

The code for the simple user interface is found in the file indonews.php. The file that "processes" the user's entry on the form is indo_scraper.php. 

There are also separate files, indo_scraperCRON-first.php and indo_scraperCRON.others.php, that send the results of the crawler every one hour to email addresses. The scheduling is done through my server's Cron Job. 

Other files in the directory represent the codes needed to scrape the required data from the individual news sites. The files are separated this way so that if there are any changes to the DOM/HTML of any of these news sites, only the affected files have to be amended. 

## Stack

There is no framework used. The programme is built purely using PHP. This was good enough for the objectives of this programme. 

