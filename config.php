<?php

return [
  'database' => [
    'dbname' => 'tripviewer',
    'username' => 'root',
    'password' => '',
    'connection' => 'mysql:host=127.0.0.1',
    'port' => ' 3306',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
  ],
  'install_prefix' => 'tripviewer',
  'google_map_api_key' => 'AIzaSyARzT7-H1PY8YapJo-Os6iJE1AU7QWLb8s', 
];
