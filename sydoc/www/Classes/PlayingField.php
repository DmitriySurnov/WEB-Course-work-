<?php

namespace Classes;

use Random\Randomizer;

class IgrovoePole
{
    private array $_pole = array();
    private int $n = 3;

    public function __construct($Index)
    {
        $this->init();
        $this->Peretosovka();
        $numberOfEmpty = array(19,31,43,53,59);
        $this->visiblNamber($numberOfEmpty[$Index]);
    }

    private function addNumber($Column, $row, $number)
    {
        $this->_pole[$row][$Column] = (int)$number;
        $_SESSION['IgrovoePole'] = $this;
    }

    private function Peretosovka()
    {
        $randomizer = new Randomizer();
        for ($i = 0; $i < $this->n * $this->n; $i++) {
            switch ($randomizer->nextInt() % 3) {
                case 0:
                {
                    $this->MatrixTransposition();  
                    break;
                }
                case 1:
                {
                    $this->SwapRowsInBlock(); 
                    break;
                }
                case 2:
                {
                    $this->SwapColumnsInBlock();
                    break;
                }
            }
        }
    }

    public function get_elent($Column, $row): int
    {
        return $this->_pole[$row][$Column];
    } 

    private function init(): void
    {
        $count = $this->n * $this->n;
        for ($i = 0; $i < $count; $i++) {
            $this->_pole[] = array();
            for ($j = 0; $j < $count; $j++) {
                $this->_pole[$i][] = ($i * $this->n + $i / $this->n + $j) % ($count) + 1;;
            }
        }
    }

    private function visiblNamber($numberOfEmpty)
    {
        $_SESSION['IgrovoePole'] = $this;
        $countOfEmpty = 0;
        $randomizer = new Randomizer();
        while ($countOfEmpty < $numberOfEmpty) {
            $i = $randomizer->nextInt() % ($this->n * $this->n);
            $j = $randomizer->nextInt() % ($this->n * $this->n);
            if ($this->_pole[$i][$j] == 0) continue;
            $this->_pole[$i][$j] = 0;
            $countOfEmpty++;
        }
    }

    private function MatrixTransposition() 
    {
        $count = $this->n * $this->n;
        $pole = array();
        for ($i = 0; $i < $count; $i++) {
            $pole[] = array();
            for ($j = 0; $j < $count; $j++) {
                $pole[$i][] = $this->_pole[$j][$i];
            }
        }
        $this->_pole = $pole;
    }

    private function SwapRowsInBlock()
    {
        $randomizer = new Randomizer();
        for ($block = 0; $block < $this->n; $block++) {
            $Row1 = $randomizer->nextInt() % $this->n;
            $Row2 = $randomizer->nextInt() % $this->n;
            while ($Row1 == $Row2)
                $Row2 = $randomizer->getInt(0, 2);
            $Line1 = $block * $this->n + $Row1;
            $Line2 = $block * $this->n + $Row2;
            $tmp = $this->_pole[$Line1];
            $this->_pole[$Line1] = $this->_pole[$Line2];
            $this->_pole[$Line2] = $tmp;
        }
    }

    private function _check($Column, $row): bool  
    {
        if ($this->РrovercaColumn($Column, $row) && $this->РrovercaRows($Column, $row)
            && $this->РrovercaBlock($Column, $row)) {
            return true;
        }
        return false;
    }

    public function check($Column, $row, $number): bool  
    {
        $this->addNumber($Column, $row, $number);
        if ($this->_check($Column, $row))
            return true;
        $this->addNumber($Column, $row, 0);
        return false;
    }

    private function РrovercaBlock($column, $row): bool
    {
        $blockX = -1;
        $blockY = -1;
        if ($column == 0 or $column == 1 or $column == 2) $blockX = 0;
        if ($column == 3 or $column == 4 or $column == 5) $blockX = 1;
        if ($column == 6 or $column == 7 or $column == 8) $blockX = 2;
        if ($row == 0 or $row == 1 or $row == 2) $blockY = 0;
        if ($row == 3 or $row == 4 or $row == 5) $blockY = 1;
        if ($row == 6 or $row == 7 or $row == 8) $blockY = 2;
        $blockX *= $this->n;
        $blockY *= $this->n;
        for ($i = $blockX; $i < $blockX + $this->n; $i++) {
            for ($j = $blockY; $j < $blockY + $this->n; $j++) {
                if ($i == $column and $j == $row) continue;
                if ($this->_pole[$row][$column] == $this->_pole[$j][$i])
                    return false;
            }
        }
        return true;
    }

    private function РrovercaColumn($column, $row): bool
    {
        return $this->РrovercaRowsColumn($column, $row, false);
    }  //   отлажено

    private function РrovercaRows($column, $row): bool
    {
        return $this->РrovercaRowsColumn($column, $row, true);
    } //   отлажено

    private function РrovercaRowsColumn($column, $row, $isRow): bool
    {
        for ($i = 0; $i < $this->n * $this->n; $i++) {
            if (!$isRow ? $i == $column : $i == $row)
                continue;
            if ($isRow) {
                if ($this->_pole[$row][$column] == $this->_pole[$i][$column])
                    return false;
            } else {
                if ($this->_pole[$row][$column] == $this->_pole[$row][$i])
                    return false;
            }
        }
        return true;
    }

    private function SwapColumnsInBlock()
    {
        $randomizer = new Randomizer();
        for ($block = 0; $block < $this->n; $block++) {
            $Row1 = $randomizer->nextInt() % $this->n;
            $Row2 = $randomizer->nextInt() % $this->n;
            while ($Row1 == $Row2)
                $Row2 = $randomizer->nextInt() % $this->n;
            $Line1 = $block * $this->n + $Row1;
            $Line2 = $block * $this->n + $Row2;
            for ($i = 0; $i < $this->n * $this->n; $i++) {
                $tmp = $this->_pole[$i][$Line1];
                $this->_pole[$i][$Line1] = $this->_pole[$i][$Line2];
                $this->_pole[$i][$Line2] = $tmp;
            }
        }
    } 
}
