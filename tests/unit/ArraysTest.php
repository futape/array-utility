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
            'String' => [
                [
                    [
                        'Foo',
                        'Bar',
                        'foO',
                        'Bar'
                    ]
                ],
                [
                    'Foo',
                    'Bar'
                ]
            ],
            'String, case-insensitive' => [
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
            'String, lowercased' => [
                [
                    [
                        'Foo',
                        'Bar',
                        'foO',
                        'Bam',
                        'BAM'
                    ],
                    Arrays::UNIQUE_STRING | Arrays::UNIQUE_LOWERCASE
                ],
                [
                    'foo',
                    'bar',
                    'bam'
                ]
            ],
            'Strict' => [
                [
                    [
                        '',
                        null,
                        false,
                        0,
                        '0',
                        false
                    ],
                    Arrays::UNIQUE_STRICT
                ],
                [
                    '',
                    null,
                    false,
                    0,
                    '0'
                ]
            ],
            'Forwarding' => [
                [
                    [
                        '0',
                        0,
                        false,
                        '2',
                        true,
                        1
                    ],
                    SORT_NUMERIC
                ],
                [
                    0,
                    2,
                    1
                ]
            ]
        ];
    }
}
