#! /usr/bin/env php

<?php
use Symfony\Component\Console\Application;
require 'vendor/autoload.php';
$app = new Application('Task App', '1.0');
try
{
    $pdo = new PDO('sqlite:db.sqlite');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $exception)
{
    echo 'Could not connect to the database';
    exit(1);
}
$dbAdapter = new Betteryourweb\Commands\DatabaseAdapter($pdo);

$app->add(new Betteryourweb\Commands\Openvpn\GetStatsCommand($dbAdapter));

$app->run();