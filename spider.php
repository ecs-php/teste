<?php
$url = 'http://www.gft.com/br/pt/index/discovery/publicacoes/main/00.json';
$responseBody = file_get_contents($url);
$json = json_decode($responseBody, true);
$releases = $json['results'];
$aRow = [];

foreach ($releases as $release) {
	$row = [];
	$row['description'] = addslashes(strip_tags($release['text']));
	$row['link'] = 'http://www.gft.com' . $release['link'];
	$row['tags'] = json_encode(explode(', ', $release['dates']['kicker']));
	$row['title'] = addslashes($release['headline']);
	$aRow[md5($row['link'])] = $row;
}

echo json_encode(array_values($aRow));