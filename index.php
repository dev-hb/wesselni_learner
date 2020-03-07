<?php


require_once 'vendor/autoload.php';
require_once 'autoload.php';
/*
use Phpml\Classification\KNearestNeighbors;

$samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
$labels = ['a', 'a', 'a', 'b', 'b', 'b'];

$classifier = new KNearestNeighbors();
$classifier->train($samples, $labels);

echo $classifier->predict([3, 2]);
// return 'b'
*/

$offersClassifier = new OffersClassifier();
$offersClassifier->getDracula()->setFields([
    'startcity', 'targetcity'
]);

$offersClassifier->bindData();

var_dump(
    $offersClassifier->getData()
);

$offersClassifier->predict();

