<?php

use PHPUnit\Framework\TestCase;

function bubbleSort($arr)
{
    sort($arr);
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
