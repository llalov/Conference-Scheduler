<?php
$cnf['default']['connection_url'] = 'mysql:host=localhost;dbname=conference_scheduler';
$cnf['default']['username'] = 'root';
$cnf['default']['password'] = '';
$cnf['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES UTF8';
$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

return $cnf;