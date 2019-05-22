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
  'tripViewMap' => 'TripController@mapView',
  'updateForm' => 'TripAddController@updateTrip',
  'updateParse' => 'TripAddController@tripUpdateParse',
  'profil' => '',
  'ajax' => 'TripController@getAllUserTripCoord',
  'tripView' => 'TripController@showTrip',
  'tripViewListUpdate' => 'TripAddController@updateTrip',
  'tripViewListDelete' => 'TripAddController@deleteTrip',
  'routeNotDefined' => 'IndexController@routeNotDefined'
]);
