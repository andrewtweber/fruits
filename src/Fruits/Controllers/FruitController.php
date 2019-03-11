<?php namespace Fruits\Controllers;

use Fruits\Connection;
use Fruits\Wrapper;

class FruitController extends Controller
{
    public function all()
    {
        $_db = new Wrapper(new Connection(getenv('DBHOST'), getenv('DBUSER'), getenv('DBPASS'), getenv('DBNAME')));

        $_PAGE = [
            'id'          => 'all',
            'title'       => 'When Are Fruits In Season?',
            'url'         => 'all',
            'description' => 'When are fruits in season?',
            'og_image'    => [],
        ];

        //-----------------------------------------------------------------------------
        // Fruits

        $sql  = "SELECT *
            FROM `fruits`
            WHERE `easter_egg` = 0
            ORDER BY `name` ASC";
        $exec = $_db->query($sql);

        $fruits = $fruit_names = [];

        while ($fruit = $exec->fetch_assoc()) {
            $fruit['url']  = str_replace(' ', '-', $fruit['plural_name']);
            $fruits[]      = $fruit;
            $fruit_names[] = $fruit['plural_name'];

            if (count($_PAGE['og_image']) < 3) {
                $_PAGE['og_image'][] = 'http://' . getenv('DOMAIN') . '/images/fruits/' . $fruit['plural_name'] . '.jpg';
            }
        }

        return $this->view('index')
            ->with('_PAGE', $_PAGE)
            ->with('fruits', $fruits);
    }

    public function show($name)
    {
        $_db = new Wrapper(new Connection(getenv('DBHOST'), getenv('DBUSER'), getenv('DBPASS'), getenv('DBNAME')));

        $sql  = "SELECT *
            FROM `fruits`
            WHERE `name` = ?
                OR `plural_name` = ?";
        $stmt = $_db->prepare($sql);
        $stmt->bind_param('ss', str_replace('-', ' ', $name), str_replace('-', ' ', $name));
        $stmt->execute();
        $exec = $stmt->get_result();

        if ($exec->num_rows) {
            $fruit = $exec->fetch_assoc();

            // Force the plural name
            if ($var == $fruit['name'] && $fruit['name'] != $fruit['plural_name']) {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /{$fruit['plural_name']}");
                exit;
            } else {
                $fruit['url'] = str_replace(' ', '-', $fruit['plural_name']);
                $verb         = ($fruit['name'] == $fruit['plural_name']) ? 'is' : 'are';

                $_PAGE['title']    = 'When ' . ucwords($verb) . ' ' . ucwords($fruit['plural_name']) . ' In Season?';
                $_PAGE['url']      = $fruit['url'];
                $_PAGE['og_image'] = 'http://' . getenv('DOMAIN') . '/images/fruits/' . $fruit['url'] . '.jpg';

                $fruit['start_time'] = mktime(0, 0, 0, $fruit['start_month'], 1);
                $fruit['end_time']   = mktime(0, 0, 0, $fruit['end_month'], 1);

                if ($fruit['start_month'] == 1 && $fruit['end_month'] == 12) {
                    $fruit['description'] = 'All Year';
                } elseif ($fruit['start_month'] == $fruit['end_month']) {
                    $fruit['description'] = date('F', $fruit['start_time']);
                } else {
                    $fruit['description'] = date('F', $fruit['start_time']) . ' - ' . date('F', $fruit['end_time']);
                }

                $_PAGE['description'] = 'When ' . $verb . ' ' . $fruit['plural_name'] . ' in season? ' . $fruit['description'];

                return $this->view('fruit')
                    ->with('_PAGE', $_PAGE)
                    ->with('fruit', $fruit);
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            require_once(__DIR__ . '/error.php');
            exit;
        }
    }
}
