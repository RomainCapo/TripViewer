<?php

$router->define([
  '' => 'ConnectionController',
  'index' => 'ConnectionController',
  'login' => 'ConnectionController@parseLogin'
]);
