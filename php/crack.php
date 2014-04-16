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

        if(!empty($this->array_sudoku[$x][$y]))
        {
            if($y < 8)
                return $this->solve($x, $y+1);
            else
            {
                $tmp = $y;
                $y = 0;
                if($this->solve($x+1, $y))
                    return true;
                $y = $tmp;
            }
        }
        else
        {
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
                if(!$flag)
                    continue;

                //开始设置
                $this->array_sudoku[$x][$y] = $n;
                if(($x == 0 && $x == $y) || ($x == 0 && $y < 9))
                {
                    //echo $y. '<<<<<<<'. $flag.'===='.$this->array_sudoku[$x][$y] . '//' . $n;
                    //var_dump($this->array_sudoku[$x]);
                }
                if($y < 8)
                {
                    if($this->solve($x, $y + 1))
                        return true;
                }
                else
                {
                    $tmp = $y;
                    $y = 0;
                    if($this->solve($x + 1, $y))
                        return true;
                    $y = $tmp;
                }

                $this->array_sudoku[$x][$y] = '';

            }
        }
        return false;
    }

    public function getSolution()
    {
        return $this->array_sudoku;
    }
}
