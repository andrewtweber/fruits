<?php namespace Fruits;

use mysqli;

/**
 * This class extends mysqli. The only differences are:
 *   function __construct does NOT create a connection, it simply stores the DB connection info
 *   function connect is a NEW function which does call the parent mysqli::__construct
 * All other methods simply call parent mysqli::$method
 *
 * @author andrew
 */
class Connection extends mysqli
{
    /**
     * @var mysqli
     */
    protected $connection = null;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $database;

    /**
     * @param  string $host
     * @param  string $user
     * @param  string $password
     * @param  string $database
     */
    public function __construct($host, $user, $password, $database)
    {
        $this->host     = $host;
        $this->user     = $user;
        $this->password = $password;
        $this->database = $database;
    }

    /**
     * Creates a MySQL connection only if one does not already exist
     */
    public function quickConnect()
    {
        if ($this->connection === null) {
            $this->connection = true;
            parent::__construct($this->host, $this->user, $this->password, $this->database);

            if (defined('DEBUG')) {
                echo "Connection created";
            }
        }
    }
}
