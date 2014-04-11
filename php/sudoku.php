<?php
class sudoku
{
    private $array_init = array();
    private $complexity = 0.3;
    private $complexity_upper = 0.8;

    public function __construct()
    {
        for($i = 0; $i < 9; $i++)
        {
            $tmp = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
            for($j = 0; $j < 9; $j++)
            {
                if($i == 0)
                {
                    $rndIndex = rand(0, count($tmp) - 1);
                    $this->array_init[$i][$j] = $tmp[$rndIndex];
                    unset($tmp[$rndIndex]);
                    $tmp = array_values($tmp);
                    continue;
                }

                $this->array_init[$i][$j] = 0;
            }
        }        

    }

    /**
     * 递归设置
     * */
    private function init($x = 1, $y = 0)
    {
        //坐标x,y上限是8
        if($x > 8 || $y > 8)
            return true;

        for($n = 1; $n < 10; $n++)
        {
            //检测行
            if(in_array($n, $this->array_init[$x]))
                continue;

            $flag = true;
            //检测列
            for($j = 0; $j < $x; $j++)
            {
                if($this->array_init[$j][$y] == $n)
                {
                    $flag = false;
                    break;
                }
            }
            if($flag)
            {
                //检测九宫格
                $d_x = floor($x / 3) * 3;
                $d_y = floor($y / 3) * 3;
                for($j = 0; $j < 3; $j++)
                {
                    for($k = 0; $k < 3; $k++)
                    {
                        if($this->array_init[$d_x + $j][$d_y + $k] == $n)
                        {
                            $flag =false;
                            break;
                        }
                    }
                    if(!$flag)
                        break;
                }

            }
            else
                continue;

            //开始设置
            $this->array_init[$x][$y] = $n;
            if($y < 8)
            {
                if($this->init($x, $y + 1))
                    return true;

            }
            else
            {
                $y = 0;
                if($x < 8)
                {
                    if($this->init($x + 1, $y))
                        return true;
                }
                else
                    return true;
            }
            $this->array_init[$x][$y] = 0;

        }
        return false;
    }

    public function generate()
    {
        $this->init();
        echo json_encode($this->array_init);
        exit;
    }
}

$sudoku = new sudoku();
$sudoku->generate();
