<?php
$query = require 'app/bootstrap.php';

require Router::load('routes.php')->direct(Request::uri(),Request::method());
