<?php

$router->define([
  'index' => 'ConnectionController',
  '' => 'ConnectionController',

  'login' => 'ConnectionController@parseLogin'
]);
