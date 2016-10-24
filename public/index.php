<?php
require_once(__DIR__ . '/../include/connect.php');

$_PAGE = array(
    'title' => 'What Fruits Are In Season Now?',
    'og_image' => array()
);

//-----------------------------------------------------------------------------
// Months

$months = array();
for ($i=1; $i<=12; $i++) {
    $time = mktime(0, 0, 0, $i, 1);
    $name = strtolower(date('F', $time));
    
    $months[$name] = $i;
}
$month = strtolower(date('F'));
$m = date('n');

//-----------------------------------------------------------------------------
// Check if URL is for a month or a fruit

if (isset($_GET['var'])) {
    $var = strtolower($_GET['var']);

    if (isset($months[$var])) {
        $month = $var;
        $m = $months[$month];
        $_PAGE['title'] = 'What Fruits Are In Season In ' . ucwords($month) . '?';
    } else {
        $sql = "SELECT *
            FROM `fruits`
            WHERE `name` = ?
                OR `plural_name` = ?";
        $stmt = $_db->prepare($sql);
        $stmt->bind_param('ss', str_replace('-', ' ', $var), str_replace('-', ' ', $var));
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
                $verb = ($fruit['name'] == $fruit['plural_name']) ? 'is' : 'are';

                $_PAGE['title'] = 'When ' . ucwords($verb) . ' ' . ucwords($fruit['plural_name']) . ' In Season?';
                $_PAGE['url'] = $fruit['url'];
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
            
                $Smarty->assign('fruit', $fruit);
                
                require_once(__DIR__ . '/../header.php');

                $Smarty->display('fruit.tpl');

                require_once(__DIR__ . '/../footer.php');
                
                exit;
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            require_once(__DIR__ . '/error.php');
            exit;
        }
    }
}

$prev = strtolower(date('F', mktime(0, 0, 0, $m-1, 1)));
$next = strtolower(date('F', mktime(0, 0, 0, $m+1, 1)));
$_PAGE['url'] = $month;

//-----------------------------------------------------------------------------
// Fruits

$sql = "SELECT *
    FROM `fruits`
    WHERE (( {$m} >= `start_month` AND {$m} <= `end_month` )
        OR ( `start_month` > `end_month` AND ( {$m} >= `start_month` OR {$m} <= `end_month` ) ))
       AND `easter_egg` = 0
    ORDER BY `name` ASC";
$exec = $_db->query($sql);

$fruits = $fruit_names = array();

while ($fruit = $exec->fetch_assoc()) {
    $fruit['url'] = str_replace(' ', '-', $fruit['plural_name']);
    $fruits[] = $fruit;
    $fruit_names[] = $fruit['plural_name'];
    
    if (count($_PAGE['og_image']) < 3) {
        $_PAGE['og_image'][] = 'http://' . getenv('DOMAIN') . '/images/fruits/' . $fruit['plural_name'] . '.jpg';
    }
}

$_PAGE['description'] = 'What fruits are in season in ' . ucwords($month) . '? ' . ucfirst(implode(', ', $fruit_names));

$Smarty->assign('month', $month);
$Smarty->assign('m', $m);
$Smarty->assign('prev', $prev);
$Smarty->assign('next', $next);

$Smarty->assign('fruits', $fruits);

require_once(__DIR__ . '/../header.php');

$Smarty->display('index.tpl');

require_once(__DIR__ . '/../footer.php');
