<?php

$exec = shell_exec('git pull origin master');
if ($exec) {
  return true;
} else {
  return false;
}
?>