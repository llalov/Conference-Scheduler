<?php
/**
 * Route -> namespace of the route.
 * Use lowercase for keys.
 * No request method means get
 */

const GOES_TO = 'goesTo'; // witch controller it goes to
const METHODS = 'methods';
const REQUEST_METHOD = 'requestMethod';
const NS = 'namespace';
const CONTROLLERS = 'controllers';

// Default
$cnf['*'][NS] = 'Controllers';

// Home
$cnf['*'][CONTROLLERS]['home'][GOES_TO] = 'index';
$cnf['*'][CONTROLLERS]['home'][METHODS]['index'] = 'index';
$cnf['*'][CONTROLLERS]['home'][REQUEST_METHOD]['index'] = 'get';

// Login
$cnf['*'][CONTROLLERS]['user'][GOES_TO] = 'user';
$cnf['*'][CONTROLLERS]['user'][METHODS]['login'] = 'login';
$cnf['*'][CONTROLLERS]['user'][REQUEST_METHOD]['login'] = 'post';
// Register
$cnf['*'][CONTROLLERS]['user'][METHODS]['register'] = 'register';
$cnf['*'][CONTROLLERS]['user'][REQUEST_METHOD]['register'] = 'post';
// Logout
$cnf['*'][CONTROLLERS]['user'][METHODS]['logout'] = 'logout';

// Api
$cnf['*'][CONTROLLERS]['api'][GOES_TO] = 'api';
$cnf['*'][CONTROLLERS]['api'][METHODS]['index'] = 'index';

return $cnf;