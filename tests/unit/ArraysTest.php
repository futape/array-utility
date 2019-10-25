<?php


use Futape\Utility\ArrayUtility\Arrays;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Futape\Utility\ArrayUtility\Arrays
 */
class ArraysTest extends TestCase
{
    public function testFlatten()
    {
        $this->assertEquals(
            [
                'foo',
                'bar',
                'baz'
            ],
            Arrays::flatten(
                [
                    'foo',
                    [
                        'bar',
                        [
                            'baz'
                        ]
                    ]
                ]
            )
        );
    }

    public function testFlattenWithKeys()
    {
        $this->assertEquals(
            [
                'foo',
                'bar',
                'baz',
                'bam'
            ],
            Arrays::flatten(
                [
                    'foo',
                    'bar' => [
                        'baz' => [
                            'bam'
                        ]
                    ]
                ],
                true
            )
        );
    }
}
