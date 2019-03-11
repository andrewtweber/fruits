<?php namespace Fruits\Controllers;

use function Fruits\base_path;
use Fruits\Connection;
use Fruits\Wrapper;
use Jenssegers\Blade\Blade;

abstract class Controller
{
    /**
     * @var Wrapper
     */
    protected $db;

    public function __construct()
    {
        // Detect mobile device
        if (isset($_GET['mobile'])) {
            setcookie('no_mobile', '', time() - 3600, '/', getenv('COOKIE_DOMAIN'));
            setcookie('mobile', '1', 2145916800, '/', getenv('COOKIE_DOMAIN'));
        } elseif (isset($_GET['no_mobile'])) {
            setcookie('mobile', '', time() - 3600, '/', getenv('COOKIE_DOMAIN'));
            setcookie('no_mobile', '1', 2145916800, '/', getenv('COOKIE_DOMAIN'));
        }

        $this->db = new Wrapper(new Connection(getenv('DBHOST'), getenv('DBUSER'), getenv('DBPASS'), getenv('DBNAME')));
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function view($path)
    {
        $blade = new Blade([base_path() . '/resources/views'], base_path(). '/storage/cache');

        $is_mobile = \Fruits\is_mobile();

        // Smaller/larger images
        $smaller = false;
        if (isset($_COOKIE['smaller'])) {
            $smaller = true;
        }
        if (isset($_GET['smaller'])) {
            setcookie('smaller', '1', 2145916800, '/', getenv('COOKIE_DOMAIN'));
            $smaller = true;
        } elseif (isset($_GET['larger'])) {
            setcookie('smaller', '', time() - 3600, '/', getenv('COOKIE_DOMAIN'));
            $smaller = false;
        }

        return $blade->make($path)
            ->with('is_mobile', $is_mobile)
            ->with('smaller', $smaller);
    }

    /**
     * @return mixed
     */
    public function error($path)
    {
        return $this->view('error');
    }
}
