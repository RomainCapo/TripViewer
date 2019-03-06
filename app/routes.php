<?php

$router->define([
  '' => 'ConnectionController',
  'index' => 'ConnectionController',
  'login' => 'ConnectionController@login',
  'loginParse' => 'ConnectionController@loginParse',
  'register' => 'ConnectionController@register',
  'registerParse' => 'ConnectionController@registerParse',
  'logout' => 'ConnectionController@logout',
  'tripAdd' => 'TripAddController',
  'tripAddParse' => 'TripAddController@tripAddParse',
  'tripViewList' => 'TripController',
  'tripViewMap' => '',
  'about' => '',
  'profil' => '',
  'debug' => 'TripAddController@test',
  'test' => 'ConnectionController@test',
]);
