<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

class crack {
    private $array_sudoku = array();
    public function __construct()
    {
        
    }

    public function setParams($sudoku)
    {
       $this->array_sudoku = $sudoku; 
    } 

    public function solve($x = 0, $y = 0)
    {
        if($x > 8 || $y > 8)
            return true;
        if($this->array_sudoku[$x][$y] != '')
        {
            if($y < 8)
            {
                if($this->solve($x, $y+1))
                    return true;
                return false;
            }
            else
            {
                if($x < 8)
                {
                    $y = 0;
                    if($this->solve($x+1, $y))
                        return true;
                    return false;

                }
            }
        }

        for($n = 1; $n < 10; $n++)
        {
            if(in_array($n, $this->array_sudoku[$x]))
                continue;

            $flag = true;
            //检测列
            for($j = 0; $j < 9; $j++)
            {
                if($this->array_sudoku[$j][$y] == $n)
                {
                    $flag = false;
                    break;
                }
            }
            if(!$flag)
                continue;
            //检测九宫格
            $d_x = floor($x / 3) * 3;
            $d_y = floor($y / 3) * 3;
            for($j = 0; $j < 3; $j++)
            {
                for($k = 0; $k < 3; $k++)
                {
                    if($this->array_sudoku[$d_x + $j][$d_y + $k] == $n)
                    {
                        $flag =false;
                        break;
                    }
                }
                if(!$flag)
                    break;
            }

            //开始设置
            $this->array_sudoku[$x][$y] = $n;
            if($y < 8)
            {
                if($this->solve($x, $y + 1))
                    return true;
            }
            else
            {

                if($x < 8)
                {
                    $y = 0;
                    if($this->solve($x + 1, $y))
                        return true;
                }
                else
                    return true;
            }

            $this->array_sudoku[$x][$y] = '';

        }
        return false;
    }

    public function getSolution()
    {
        return $this->array_sudoku;
    }
}
