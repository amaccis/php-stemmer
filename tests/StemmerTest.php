<?php
declare(strict_types=1);

/**
 * @author Andrea Maccis <andrea.maccis@gmail.com>
 */

namespace Amaccis\Stemmer\Tests;

use Amaccis\Stemmer\Stemmer;
use PHPUnit\Framework\TestCase;

class StemmerTest extends TestCase
{

    public function testAlgorithms(): void
    {

        $algorithms = Stemmer::algorithms();
        $this->assertCount(25, $algorithms);

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @dataProvider stemWordProvider
     */
    public function testStemWord(string $algorithm, string $word, string $stem): void
    {

        $stemmer = new Stemmer($algorithm);
        $this->assertEquals($stem, $stemmer->stemWord($word));

    }

    public function stemWordProvider(): array
    {

        return [
            ['english', 'cycling', 'cycl'],
            ['italian', 'camminare', 'cammin']
        ];

    }

    /**
     * @param string $algorithm
     * @param array $words
     * @param array $stems
     *
     * @dataProvider stemWordsProvider
     */
    public function testStemWords(string $algorithm, array $words, array $stems): void
    {

        $stemmer = new Stemmer($algorithm);
        $this->assertEquals($stems, $stemmer->stemWords($words));

    }

    public function stemWordsProvider(): array
    {

        return [
            ['english', ['cycling', 'doors'], ['cycl', 'door']],
            ['italian', ['camminare', 'porte'], ['cammin', 'port']]
        ];

    }

}
