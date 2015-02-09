<?php
/**
 * This class wraps around mysqli so that it can catch all methods
 * This allows us to create aliases easily, as well as only create the connection
 * for certain methods
 * 
 * @author andrew
 */
class Wrapper
{
	protected $mysqli;

	public function __construct(mysqli_extended $mysqli) {
		$this->mysqli = $mysqli;
	}

	/**
	 * Catch ALL methods and create a connection before invoking the method on
	 * the mysqli object
	 * 
	 * @param string $method the name of the method
	 * @param array $args the list of arguments
	 * @return mixed whatever the $method function returns
	 */
	public function __call($method, $args)
	{
		// Alias methods
		if( $method == 'escape' ) { $method = 'real_escape_string'; }
		
		switch( $method )
		{			
			// Create a connection for these methods
			case 'query':
			case 'real_escape_string':
			case 'select_db':
				$this->mysqli->connect();
				break;
		
			// Don't create one for anything else
			default:
				break;
		}

		if( defined('DEBUG') ) {
			echo "Running method {$method}<br>";
			if( $method == 'query' ) { var_dump($args[0]); }
		}

		return call_user_func_array(array($this->mysqli, $method), $args);
	}

	final public function __set( $name, $value ) {
		$this->mysqli->$name = $value;
	}
	final public function __get( $name ) {
		return $this->mysqli->$name;
    }
	final public function __isset( $name ) {
		return isset($this->mysqli->$name);
	}
}

/**
 * This class extends mysqli. The only differences are:
 *   function __construct does NOT create a connection, it simply stores the DB connection info
 *   function connect is a NEW function which does call the parent mysqli::__construct
 * All other methods simply call parent mysqli::$method
 * 
 * @author andrew
 */
class mysqli_extended extends mysqli
{
	protected $_connection = null;
	
	protected $_dbhost, $_dbuser, $_dbpass, $_dbname;

	public function __construct($DBHOST, $DBUSER, $DBPASS, $DBNAME)
	{
		$this->_dbhost = $DBHOST;
		$this->_dbuser = $DBUSER;
		$this->_dbpass = $DBPASS;
		$this->_dbname = $DBNAME;
	}

	/**
	 * Creates a MySQL connection only if one does not already exist
	 */
	public function connect()
	{
		if( $this->_connection === null )
		{	
			$this->_connection = true;
			parent::__construct($this->_dbhost, $this->_dbuser, $this->_dbpass, $this->_dbname);

			if( defined('DEBUG')) {
				echo 'Connection created';
			}
		}
	}
}
