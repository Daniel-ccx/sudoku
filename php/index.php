<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('_ROOT_', dirname(dirname(__FILE__)));
include_once(_ROOT_ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'sudoku.php');
$sudoku = new sudoku();
$original = $sudoku->generate();


$sudoku_arr = $sudoku->getSudoku();
foreach($sudoku_arr as $k => $v)
{
    echo $k . ' =>>>> ';
    foreach($v as $j => $i)
    {
        echo '['.$j.']=>('.$i.')';
    }
    echo "<hr>";
}

//获取破解
include_once(_ROOT_ . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'crack.php');
$crack = new crack();

$crack->setParams($sudoku_arr);
$crack->solve();
$solution = $crack->getSolution();
echo "original:<br>";
echo "<style>table td{width: 30px; height:30px;}</style>";
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
