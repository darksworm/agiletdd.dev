<?php

use PHPUnit\Framework\TestCase;

function bubbleSort($arr)
{
    $temp;

    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 1; $j < (count($arr) - $i); $j++) {
            if ($arr[$j - 1] > $arr[$j]) {
                $temp = $arr[$j - 1];
                $arr[$j - 1] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }

    return $arr;
}

class SortTest extends TestCase
{
    public function test_sortedEmptyArray_isEmptyArray()
    {
        $this->assertEquals([], bubbleSort([]));
    }

    public function test_arrayAlreadySorted_isStillSorted()
    {
        $this->assertEquals([1, 2, 3], bubbleSort([1, 2, 3]));
    }
}
