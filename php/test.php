<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('_ROOT_', dirname(dirname(__FILE__)));
include_once(_ROOT_ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'crack.php');
$crack = new crack();

$sudoku_arr = array(
    0 => array('', '', '', '', '', 5, 2, '', ''),
    1 => array(2, '', '', '', 7, '', '', 6, ''),
    2 => array('', 7, '', '', 4, '', 1, 3, 5),
    3 => array('', '', 2, 4, '', '', '', 9, 8),
    4 => array(4, '', '', 8, '', 1, '', 2, ''),
    5 => array(8, 9, '', '', '', 3, '', 1, 4),
    6 => array('', 2, 1, '', 8, '', '', 7, 3),
    7 => array(7, '', 4, 9, 3, '', '', 5, ''),
    8 => array('', '', '', '', '', '', 6, 4, '')
);
$start = microtime(true);
$sudoku_arr = array(
    0 => array('', '', '2', '', '3', '9', '', '4', ''),
    1 => array('', '1', '', '', '7', '', '', '', ''),
    2 => array('', '', '5', '', '', '8', '', '', ''),
    3 => array('', '', '', '8', '', '4', '2', '', '9'),
    4 => array('5', '', '', '7', '', '3', '', '', '1'),
    5 => array('2', '', '8', '6', '', '1', '', '', ''),
    6 => array('', '', '', '4', '', '', '9', '', ''),
    7 => array('', '', '', '', '8', '', '', '7', ''),
    8 => array('', '4', '', '9', '6', '', '8', '', '')
);

$original = array(
    0 => array(1,4,9,3,6,5,2,8,7),
    1 => array(2,3,5,1,7,8,4,6,9),
    2 => array(6,7,8,2,4,9,1,3,5),
    3 => array(3,1,2,4,5,6,7,9,8),
    4 => array(4,5,7,8,9,1,3,2,6),
    5 => array(8,9,6,7,2,3,5,1,4),
    6 => array(5,2,1,6,8,4,9,7,3),
    7 => array(7,6,4,9,3,2,8,5,1),
    8 => array(9,8,3,5,1,7,6,4,2)
);
$crack->setParams($sudoku_arr);

$crack->solve();
$solution = $crack->getSolution();
echo "<style>table td{width: 30px; height:30px; border: 1px solid green;text-align:center;}</style>";

echo "item:";
echo "<table>";
foreach($sudoku_arr as $k => $v)
{
    echo "<tr>";
    foreach($v as $j => $i)
    {
        echo "<td name='g_{$k}{$j}'>{$i}</td>";
    }
    echo "</tr>";
}
echo "</table>";

/*echo "original:<br>";
echo "<table>";
foreach($original as $k => $v)
{
    echo "<tr>";
    foreach($v as $j => $i)
    {
        echo "<td name='g_{$k}{$j}'>{$i}</td>";
    }
    echo "</tr>";
}
echo "</table>";
 */
echo "solved:";
echo "<br>";

echo "<table>";

foreach($solution as $k => $v)
{
    echo "<tr>";
    foreach($v as $j => $i)
    {
        echo "<td name='g_{$k}{$j}'>{$i}</td>";
    }
    echo "</tr>";
}
echo "</table>";
$end = microtime(true);
echo "It took:";
echo $end - $start;
echo " Seconds";
