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

    /** @dataProvider unsortedArrayProvider */
    public function test_unsortedArray_getsSorted(array $unsorted, array $sorted)
    {
        $this->assertEquals($sorted, bubbleSort($unsorted));
    }

    public static function unsortedArrayProvider()
    {
        return [
            ['unsorted' => [3, 2, 1], 'sorted' => [1, 2, 3]],
            ['unsorted' => [0, 0, 2, 1], 'sorted' => [0, 0, 1, 2]],
            ['unsorted' => [7, 0, 2, 1], 'sorted' => [0, 1, 2, 7]],
        ];
    }
}
