<?php
declare(strict_types=1);

namespace Amaccis\Stemmer\Tests;

use Amaccis\Stemmer\Enum\CharacterEncodingEnum;
use Amaccis\Stemmer\Exception\UnavailableAlgorithmException;
use Amaccis\Stemmer\Stemmer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StemmerTest extends TestCase
{

    public function testThatAlgorithmsReturnsAnArrayNotEmpty(): void
    {

        $algorithms = Stemmer::algorithms();
        $this->assertNotEmpty($algorithms);

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
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordUtf8CharencProvider')]
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
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordUtf8CharencProvider')]
    public function testThatStemWordWithUtf8CharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::UTF_8);
        $this->assertEquals($stem, $stemmer->stemWord($word));

    }

    /**
     * @return array<int, array{string, string, string}>
     */
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
            ['romanian', 'luminișurile', 'luminișur'],
            ['russian', 'взъерошенный', 'взъерошен']
        ];

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordIso88591CharencProvider')]
    public function testThatStemWordWithIso88591CharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        /** @var string $word */
        $word = iconv('UTF-8', 'ISO-8859-1', $word);
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_1);
        $actualStem = iconv('ISO-8859-1', 'UTF-8', $stemmer->stemWord($word));
        $this->assertEquals($stem, $actualStem);

    }

    /**
     * @return array<int, array{string, string, string}>
     */
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
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordIso88592CharencProvider')]
    public function testThatStemWordWithIso88592CharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        /** @var string $word */
        $word = iconv('UTF-8', 'ISO-8859-2', $word);
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_2);
        $actualStem = iconv('ISO-8859-2', 'UTF-8', $stemmer->stemWord($word));
        $this->assertEquals($stem, $actualStem);

    }

    /**
     * @return array<int, array{string, string, string}>
     */
    public static function stemWordIso88592CharencProvider(): array
    {

        return [
            ['hungarian', 'lenyűgözőnek', 'lenyűgöző'],
        ];

    }

    /**
     * @param string $algorithm
     * @param string $word
     * @param string $stem
     *
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordKoi8rCharencProvider')]
    public function testThatStemWordWithKoi8rCharencReturnsTheExpectedStem(string $algorithm, string $word, string $stem): void
    {

        /** @var string $word */
        $word = iconv('UTF-8', 'KOI8-R', $word);
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::KOI8_R);
        $actualStem = iconv('KOI8-R', 'UTF-8', $stemmer->stemWord($word));
        $this->assertEquals($stem, $actualStem);

    }

    /**
     * @return array<int, array{string, string, string}>
     */
    public static function stemWordKoi8rCharencProvider(): array
    {

        return [
            ['russian', 'взъерошенный', 'взъерошен'],
        ];

    }

    /**
     * @param string $algorithm
     * @param string[] $words
     * @param string[] $stems
     *
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordsUtf8CharencProvider')]
    public function testThatStemWordsWithNoCharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $stemmer = new Stemmer($algorithm);
        $this->assertEquals($stems, $stemmer->stemWords($words));

    }

    /**
     * @param string $algorithm
     * @param string[] $words
     * @param string[] $stems
     *
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordsUtf8CharencProvider')]
    public function testThatStemWordsWithUtf8CharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::UTF_8);
        $this->assertEquals($stems, $stemmer->stemWords($words));

    }

    /**
     * @return array<int, array{string, string[], string[]}>
     */
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
            ['romanian', ['luminișurile', 'personalităţilor'], ['luminișur', 'personal']],
            ['russian', ['взъерошенный', 'затруднительное'], ['взъерошен', 'затруднительн']],
        ];

    }

    /**
     * @param string $algorithm
     * @param string[] $words
     * @param string[] $stems
     *
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordsIso88591CharencProvider')]
    public function testThatStemWordsWithIso88591CharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $words = array_map(
            fn ($word) => iconv('UTF-8', 'ISO-8859-1', $word),
            $words
        );
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_1);
        /** @var string[] $words */
        $actualStems = array_map(
            fn ($stem) => iconv('ISO-8859-1', 'UTF-8', $stem),
            $stemmer->stemWords($words)
        );
        $this->assertEquals($stems, $actualStems);

    }

    /**
     * @return array<int, array{string, string[], string[]}>
     */
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
     * @param string[] $words
     * @param string[] $stems
     *
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordsIso88592CharencProvider')]
    public function testThatStemWordsWithIso88592CharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $words = array_map(
            fn ($word) => iconv('UTF-8', 'ISO-8859-2', $word),
            $words
        );
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::ISO_8859_2);
        /** @var string[] $words */
        $actualStems = array_map(
            fn ($stem) => iconv('ISO-8859-2', 'UTF-8', $stem),
            $stemmer->stemWords($words)
        );
        $this->assertEquals($stems, $actualStems);

    }

    /**
     * @return array<int, array{string, string[], string[]}>
     */
    public static function stemWordsIso88592CharencProvider(): array
    {

        return [
            ['hungarian', ['lenyűgözőnek', 'megháromszorozódott'], ['lenyűgöző', 'megháromszorozódot']],
        ];

    }

    /**
     * @param string $algorithm
     * @param string[] $words
     * @param string[] $stems
     *
     * @throws UnavailableAlgorithmException
     */
    #[DataProvider('stemWordsKoi8rCharencProvider')]
    public function testThatStemWordsWithKoi8rCharencReturnsTheExpectedStems(string $algorithm, array $words, array $stems): void
    {

        $words = array_map(
            fn ($word) => iconv('UTF-8', 'KOI8-R', $word),
            $words
        );
        $stemmer = new Stemmer($algorithm, CharacterEncodingEnum::KOI8_R);
        /** @var string[] $words */
        $actualStems = array_map(
            fn ($stem) => iconv('KOI8-R', 'UTF-8', $stem),
            $stemmer->stemWords($words)
        );
        $this->assertEquals($stems, $actualStems);

    }

    /**
     * @return array<int, array{string, string[], string[]}>
     */
    public static function stemWordsKoi8rCharencProvider(): array
    {

        return [
            ['russian', ['взъерошенный', 'затруднительное'], ['взъерошен', 'затруднительн']],
        ];

    }

}