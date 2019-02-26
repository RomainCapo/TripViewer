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
];
