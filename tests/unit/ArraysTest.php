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

    /**
     * @dataProvider uniqueDataProvider
     *
     * @param array $input
     * @param array $expected
     */
    public function testUnique(array $input, array $expected)
    {
        $this->assertEquals($expected, Arrays::unique(...$input));
    }

    public function uniqueDataProvider(): array
    {
        return [
            'Basic' => [
                [
                    [
                        'Foo',
                        'Bar',
                        'foO',
                        'Bam',
                        'BAM'
                    ]
                ],
                [
                    'Foo',
                    'Bar',
                    'Bam'
                ]
            ],
            'Lowercased' => [
                [
                    [
                        'Foo',
                        'Bar',
                        'foO',
                        'Bam',
                        'BAM'
                    ],
                    true
                ],
                [
                    'foo',
                    'bar',
                    'bam'
                ]
            ]
        ];
    }
}
