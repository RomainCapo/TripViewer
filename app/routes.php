<?php

$router->define([
  '' => 'ConnectionController',
  'index' => 'ConnectionController',
  'login' => 'ConnectionController@login',
  'loginParse' => 'ConnectionController@loginParse',
  'register' => 'ConnectionController@register',
  'registerParse' => 'ConnectionController@registerParse',
  'tripAdd' => 'TripAddController',
  'tripAddParse' => 'TripAddController@tripAddParse',
  'test' => 'TripAddController@test',
  'tripView' => '',
  'mapView' => '',
  'about' => '',
  'profil' => '',
]);
