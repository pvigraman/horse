<?php
$app=[];

$app['config']= require 'config.php';
require 'Router.php';
require 'Request.php';
require 'database/Connection.php';
require 'database/QueryBuilder.php';

return new QueryBuilder(Connection::make($app['config']['database']));
