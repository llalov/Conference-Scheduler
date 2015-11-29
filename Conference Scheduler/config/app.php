<?php
$cnf['default_controller'] = 'Index';
$cnf['default_method'] = 'index';

$cnf['namespaces']['Controllers'] = '../Controllers/';
$cnf['namespaces']['Routers'] = '../Routers/';
$cnf['namespaces']['Models'] = '../Models/';

$cnf['displayExceptions'] = true;

$cnf['session']['auto_start'] = true;
$cnf['session']['type'] = 'native';
$cnf['session']['name'] = 'app_session';
$cnf['session']['lifetime'] = 60 * 60 * 12;
$cnf['session']['path'] = '/';
$cnf['session']['domain'] = '';
$cnf['session']['secure'] = false;

return $cnf;