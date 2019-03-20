<?php
require 'core/database/Connection.php';
require 'core/Router.php';
require 'core/Request.php';
require 'core/App.php';
require 'helpers/Helper.php';
require 'core/database/Model.php';
require 'app/GoogleMapsApiHelper.php';

require 'vendor/autoload.php';

require 'app/models/Destination.php';
require 'app/models/Trip.php';
require 'app/models/User.php';
require 'app/models/Transport.php';

session_start();

App::load_config("config.php");

App::set('dbh', Connection::make(App::get('config')['database']));
