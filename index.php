<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 2016-04-25
 * Time: 23:04
 */

require_once 'PhpDBC.php';
require_once 'PhpDBCException.php';


try {
//    $server = PhpDBC::createServer('servers');
    $dbc = new PhpDBC('servers');
    $dbc->createDatabase('testDatabase.con', true);
    $dbc->createDatabase('library.con', true);
    $dbc->createDatabase('vehicles.con', true);
    $dbc->createDatabase('secretDatabase.con', true);
    $dbc->dropDatabase('lala2223.con', true);

    $dbc->showDatabases();
} catch (PhpDBCException $ex) {
    die('<span style=\'color: red\'> Error: ' . $ex->getCode() . ' - ' . $ex->getMessage());
} catch (Exception $ex) {
    die('<span style=\'color: red\'> Error: ' . $ex->getCode() . ' - ' . $ex->getMessage());
}

