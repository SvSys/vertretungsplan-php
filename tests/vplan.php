<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Vertretungsplan\HttpManager;


/**
 * Created by PhpStorm.
 * User: jan
 * Date: 28.06.15
 * Time: 20:43
 */

$http = new HttpManager("http://ohgspringe.de/phocadownload/plan/subst_002.htm");

$plan = $http->fetchPlan();

error_reporting(E_ALL);

echo json_encode($plan);