<?php namespace Fruits\Controllers;

use Jenssegers\Blade\Blade;

abstract class Controller
{
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
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function view($path)
    {
        $blade = new Blade([__DIR__ . '/../resources/views'], __DIR__ . '/../storage/cache');

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
}
