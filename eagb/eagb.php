<?php

require_once dirname(__FILE__) . '/bootstrap.php';
try
{
    $eaGB = new eaGB(isset($_GET['eagb'])?$_GET['eagb']:'', _EA_ROOT . '/config/settings.php');
    $eaGB->dispatch();
}
catch (Exception $e)
{
    $eaGB = null;
    $eaGB = $e->getMessage();
}
