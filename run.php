<?php
include_once("snapsortScraper.php");
include_once("csvGenerator.php");

$snapsortUrls = array(
	'http://snapsort.com/compare/Nikon-D600-vs-Nikon-D800/specs',
	'http://snapsort.com/compare/Nikon-D5100-vs-Nikon-D3200/specs',
	'http://snapsort.com/compare/Nikon-D5100-vs-Nikon_D7000/specs',
);

$scraper = new snapsortScraper($snapsortUrls);
$allCameras = $scraper->run();

$csvGenerator = new csvGenerator("nikon.csv");
$csvGenerator->generate($allCameras);