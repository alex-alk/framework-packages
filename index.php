<?php

require_once 'vendor/autoload.php';

use HttpClient\Client\HttpClient;
use HttpClient\Factory\RequestFactory;

$client = new HttpClient();

$requestFactory = new RequestFactory();

$request = $requestFactory->createRequest(RequestFactory::METHOD_GET, 'https://www.google.com/searh/?query=q');
$uri = $request->getUri()->__toString();


$request = $client->sendRequest($request);