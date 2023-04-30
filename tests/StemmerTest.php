<?php
declare(strict_types=1);

namespace Amaccis\Stemmer\Tests;

use Amaccis\Stemmer\Enum\CharacterEncodingEnum;
use Amaccis\Stemmer\Exception\UnavailableAlgorithmException;
use Amaccis\Stemmer\Stemmer;
use PHPUnit\Framework\TestCase;

class StemmerTest extends TestCase
{

    public function testThatAlgorithmsReturnsTheExpectedArray(): void
    {

        $expectedAlgorithms = [
            'arabic',
            'armenian',
            'basque',
            'catalan',
            'danish',
            'dutch',
            'english',
            'finnish',
            'french',
            'german',
            'greek',
            'hindi',
            'hungarian',
            'indonesian',
            'irish',
            'italian',
            'lithuanian',
            'nepali',
            'norwegian',
            'porter',
            'portuguese',
            'romanian',
            'russian',
            'serbian',
            'spanish',
            'swedish',
            'tamil',
            'turkish',
            'yiddish'
        ];
        $algorithms = Stemmer::algorithms();
        $this->assertEquals($expectedAlgorithms, $algorithms);

    }

    /**
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemmerWithUnavailableAlgorithmThrowsException(): void
    {

        $this->expectException(UnavailableAlgorithmException::class);
        $algorithm = "dothraki";
        new Stemmer($algorithm);

    }

    public function testThatStemmerWithAvailableAlgorithmAndUnavailableEncodingThrowsException(): void
    {

        $this->expectException(UnavailableAlgorithmException::class);
        $algorithm = "italian";
        new Stemmer($algorithm, CharacterEncodingEnum::KOI8_R);

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @dataProvider stemWordUtf8CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordWithNoCharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        $stemmer = new Stemmer($algorithm);
        $this->assertEquals($stem, $stemmer->stemWord($word));

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @dataProvider stemWordUtf8CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordWithUtf8CharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::UTF_8);
        $this->assertEquals($stem, $stemmer->stemWord($word));

    }

    public static function stemWordUtf8CharencProvider(): array
    {

        return [
            ['english', 'cycling', 'cycl'],
            ['italian', 'camminare', 'cammin'],
            ['portuguese', 'atribuição', 'atribuiçã'],
            ['basque', 'aberatsenetakoa', 'aberatse'],
            ['catalan', 'arruïnada', 'arru'],
            ['danish', 'afbildningerne', 'afbildning'],
            ['hungarian', 'lenyűgözőnek', 'lenyűgöző'],
            ['romanian', 'luminişurile', 'luminişur'],
            ['russian', 'взъерошенный', 'взъерошен']
        ];

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @dataProvider stemWordIso88591CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordWithIso88591CharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        /** @var string $word */
        $word = iconv('UTF-8', 'ISO-8859-1', $word);
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_1);
        $actualStem = iconv('ISO-8859-1', 'UTF-8', $stemmer->stemWord($word));
        $this->assertEquals($stem, $actualStem);

    }

    public static function stemWordIso88591CharencProvider(): array
    {

        return [
            ['basque', 'aberatsenetakoa', 'aberatse'],
            ['catalan', 'arruïnada', 'arru'],
            ['danish', 'afbildningerne', 'afbildning'],
        ];

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @dataProvider stemWordIso88592CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordWithIso88592CharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        /** @var string $word */
        $word = iconv('UTF-8', 'ISO-8859-2', $word);
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_2);
        $actualStem = iconv('ISO-8859-2', 'UTF-8', $stemmer->stemWord($word));
        $this->assertEquals($stem, $actualStem);

    }

    public static function stemWordIso88592CharencProvider(): array
    {

        return [
            ['hungarian', 'lenyűgözőnek', 'lenyűgöző'],
            ['romanian', 'luminişurile', 'luminişur'],
        ];

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @dataProvider stemWordKoi8rCharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordWithKoi8rCharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        /** @var string $word */
        $word = iconv('UTF-8', 'KOI8-R', $word);
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::KOI8_R);
        $actualStem = iconv('KOI8-R', 'UTF-8', $stemmer->stemWord($word));
        $this->assertEquals($stem, $actualStem);

    }

    public static function stemWordKoi8rCharencProvider(): array
    {

        return [
            ['russian', 'взъерошенный', 'взъерошен'],
        ];

    }

    /**
     * @param string $algorithm
     * @param array $words
     * @param array $stems
     *
     * @dataProvider stemWordsUtf8CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordsWithNoCharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $stemmer = new Stemmer($algorithm);
        $this->assertEquals($stems, $stemmer->stemWords($words));

    }

    /**
     * @param string $algorithm
     * @param array $words
     * @param array $stems
     *
     * @dataProvider stemWordsUtf8CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordsWithUtf8CharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::UTF_8);
        $this->assertEquals($stems, $stemmer->stemWords($words));

    }

    public static function stemWordsUtf8CharencProvider(): array
    {

        return [
            ['english', ['cycling', 'doors'], ['cycl', 'door']],
            ['italian', ['camminare', 'porte'], ['cammin', 'port']],
            ['portuguese', ['atribuição', 'obrigações'], ['atribuiçã', 'obrig']],
            ['basque', ['aberatsenetakoa', 'txotxongilo'], ['aberatse', 'txotxongilo']],
            ['catalan', ['gratuïtament', 'cuaespinós'], ['gratuit', 'cuaespin']],
            ['danish', ['afbildningerne', 'linnedklæderne'], ['afbildning', 'linnedklæd']],
            ['hungarian', ['lenyűgözőnek', 'megháromszorozódott'], ['lenyűgöző', 'megháromszorozódot']],
            ['romanian', ['luminişurile', 'personalităţilor'], ['luminişur', 'personal']],
            ['russian', ['взъерошенный', 'затруднительное'], ['взъерошен', 'затруднительн']],
        ];

    }

    /**
     * @param string $algorithm
     * @param array $words
     * @param array $stems
     *
     * @dataProvider stemWordsIso88591CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordsWithIso88591CharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $words = array_map(
            fn ($word) => iconv('UTF-8', 'ISO-8859-1', $word),
            $words
        );
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_1);
        $actualStems = array_map(
            fn ($stem) => iconv('ISO-8859-1', 'UTF-8', $stem),
            $stemmer->stemWords($words)
        );
        $this->assertEquals($stems, $actualStems);

    }

    public static function stemWordsIso88591CharencProvider(): array
    {

        return [
            ['basque', ['aberatsenetakoa', 'txotxongilo'], ['aberatse', 'txotxongilo']],
            ['catalan', ['gratuïtament', 'cuaespinós'], ['gratuit', 'cuaespin']],
            ['danish', ['afbildningerne', 'linnedklæderne'], ['afbildning', 'linnedklæd']],
        ];

    }

    /**
     * @param string $algorithm
     * @param array $words
     * @param array $stems
     *
     * @dataProvider stemWordsIso88592CharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordsWithIso88592CharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $words = array_map(
            fn ($word) => iconv('UTF-8', 'ISO-8859-2', $word),
            $words
        );
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_2);
        $actualStems = array_map(
            fn ($stem) => iconv('ISO-8859-2', 'UTF-8', $stem),
            $stemmer->stemWords($words)
        );
        $this->assertEquals($stems, $actualStems);

    }

    public static function stemWordsIso88592CharencProvider(): array
    {

        return [
            ['hungarian', ['lenyűgözőnek', 'megháromszorozódott'], ['lenyűgöző', 'megháromszorozódot']],
            ['romanian', ['luminişurile', 'personalităţilor'], ['luminişur', 'personal']],
        ];

    }

    /**
     * @param string $algorithm
     * @param array $words
     * @param array $stems
     *
     * @dataProvider stemWordsKoi8rCharencProvider
     * @throws UnavailableAlgorithmException
     */
    public function testThatStemWordsWithKoi8rCharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $words = array_map(
            fn ($word) => iconv('UTF-8', 'KOI8-R', $word),
            $words
        );
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::KOI8_R);
        $actualStems = array_map(
            fn ($stem) => iconv('KOI8-R', 'UTF-8', $stem),
            $stemmer->stemWords($words)
        );
        $this->assertEquals($stems, $actualStems);

    }

    public static function stemWordsKoi8rCharencProvider(): array
    {

        return [
            ['russian', ['взъерошенный', 'затруднительное'], ['взъерошен', 'затруднительн']],
        ];

    }

}