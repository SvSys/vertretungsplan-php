<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Vertretungsplan\HttpManager;


/**
 * Created by PhpStorm.
 * User: jan
 * Date: 28.06.15
 * Time: 20:43
 * Usage Example
 */

$http = new HttpManager("http://ohgspringe.de/phocadownload/plan/subst_002.htm"); //institate new HttpManager with url of the vertretungsplan

$plan = $http->fetchPlan(); //Fetch and analyze the plan

print_r($plan->getVertretungenForCourse('5a')); //Search for substitutions concerning the 5a