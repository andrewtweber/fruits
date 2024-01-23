<?php

namespace Fruits;

/**
 * This class wraps around mysqli so that it can catch all methods
 * This allows us to create aliases easily, as well as only create the connection
 * for certain methods
 *
 * @author andrew
 *
 * @method \mysqli_stmt|false prepare(string $query)
 * @method ?\mysqli_result query(string $query, int $result_mode = MYSQLI_STORE_RESULT)
 */
class Wrapper
{
    /**
     * @var Connection
     */
    protected $mysqli;

    public function __construct(Connection $mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Catch ALL methods and create a connection before invoking the method on
     * the mysqli object
     *
     * @param  string $method  the name of the method
     * @param  array  $args the list of arguments
     * @return mixed  whatever the $method function returns
     */
    public function __call($method, $args)
    {
        // Alias methods
        if ($method == 'escape') {
            $method = 'real_escape_string';
        }

        switch ($method) {
            // Create a connection for these methods
            case 'prepare':
            case 'query':
            case 'real_escape_string':
            case 'select_db':
                $this->mysqli->quickConnect();
                break;

            // Don't create one for anything else
            default:
                break;
        }

        return call_user_func_array(array($this->mysqli, $method), $args);
    }

    final public function __set($name, $value) {
        $this->mysqli->$name = $value;
    }

    final public function __get($name) {
        return $this->mysqli->$name;
    }

    final public function __isset($name) {
        return isset($this->mysqli->$name);
    }
}
