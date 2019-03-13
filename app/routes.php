<?php

$router->define([
  '' => 'IndexController',
  'index' => 'IndexController',
  'login' => 'ConnectionController@login',
  'loginParse' => 'ConnectionController@loginParse',
  'register' => 'ConnectionController@register',
  'registerParse' => 'ConnectionController@registerParse',
  'logout' => 'ConnectionController@logout',
  'tripAdd' => 'TripAddController',
  'tripAddParse' => 'TripAddController@tripAddParse',
  'tripViewList' => 'TripController',
  'tripView' => 'TripController@showTrip',
  'tripViewListEdit' => 'TripAddController@editTrip',
  'tripViewListDelete' => 'TripAddController@deleteTrip',
  'tripViewMap' => '',
  'profil' => '',
  'debug' => 'TripAddController@test',
  'test' => 'ConnectionController@test',
]);
