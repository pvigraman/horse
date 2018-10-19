<?php
$query->sql("SET FOREIGN_KEY_CHECKS = 0;TRUNCATE table progress;TRUNCATE table horses;TRUNCATE table races; 
SET FOREIGN_KEY_CHECKS = 1;
");

header("Location: /");