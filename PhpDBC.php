<?php
/**
 * Created by PhpStorm.
 * User: Pawel Kawecki
 * Date: 2016-04-25
 * Time: 21:58
 */

require_once 'PhpDBCException.php';

class PhpDBC {
    const PATH = __DIR__;

    const ERR_SERVER_NOT_EXISTS = 101;
    const ERR_SERVER_ALREADY_EXISTS = 102;
    const ERR_UNABLE_TO_CREATE_SERVER = 103;

    const ERR_DATABASE_NOT_EXISTS = 111;
    const ERR_DATABASE_ALREADY_EXISTS = 112;
    const ERR_UNABLE_TO_CREATE_DATABASE = 113;
    const ERR_UNABLE_TO_DROP_DATABASE = 114;

    private $server;

    private $login;

    private $password;

    private $database;

    public function __construct($server, $database = '', $login = '', $password = '') {

        $this->connectToServer($server);
        $this->database = $database;
        $this->login = $login;
        $this->password = $password;

        echo "The connection to the server ({$this->getServer()}) has been established!<br>" ;
    }


    public static function createServer($server) {

        $server = self::PATH . DIRECTORY_SEPARATOR . $server;

        if(file_exists($server) && is_dir($server)) {
            throw new PhpDBCException('Server already exists!', self::ERR_SERVER_ALREADY_EXISTS);
        }

        if (@mkdir($server)) {
            return $server;
        }
        throw new PhpDBCException('Unable to create server! (Probably path not exists)', self::ERR_UNABLE_TO_CREATE_SERVER);
    }

    public function createDatabase($databaseName, $ifNotExists = false) {

        if(!file_exists($this->getServer() . DIRECTORY_SEPARATOR . $databaseName)) {
            if(@!touch($this->getServer() . DIRECTORY_SEPARATOR . $databaseName)) {
                throw new PhpDBCException('Unable to create database! (Probably path not exists)', self::ERR_UNABLE_TO_CREATE_DATABASE);
            }

            echo "Database: " . $databaseName . " has been created succesfully \n <br/>";
            return true;
        }

        if(!$ifNotExists) {
            throw new PhpDBCException('Database already exists!', self::ERR_DATABASE_ALREADY_EXISTS);
        }

        return false;
    }

    public function dropDatabase($databaseName, $ifNotExists = false) {

        if(file_exists($this->getServer() . DIRECTORY_SEPARATOR . $databaseName)) {
            if(!unlink($this->getServer() . DIRECTORY_SEPARATOR . $databaseName)) {
                throw new PhpDBCException('Unable to drop database! (Probably path not exists)', self::ERR_UNABLE_TO_DROP_DATABASE);
            }

            echo "Database: " . $databaseName . " has been droped from the server \n <br/>";
            return true;
        }

        if(!$ifNotExists) {
            throw new PhpDBCException('Database not exists!', self::ERR_DATABASE_NOT_EXISTS);
        }

        return false;
    }

    public function showDatabases() {
        if ($handle = opendir($this->getServer())) {
            echo "Databases list at server {$this->getServer()} :\n <br/>";

            while (false !== ($entry = readdir($handle))) {
                echo "$entry \n <br/>";
            }

            closedir($handle);
        }
    }

    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param $server
     * @throws PhpDBCException
     */
    private function connectToServer($server)
    {
        $server = self::PATH . DIRECTORY_SEPARATOR . $server;

        if (file_exists($server) && is_dir($server)) {
            $this->server = $server;
        } else {
            throw new PhpDBCException('Unable to find server. Please ensure that server exists!', self::ERR_SERVER_NOT_EXISTS);
        }
    }
}