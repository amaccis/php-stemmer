<?php
declare(strict_types=1);

namespace Amaccis\Stemmer;

use Amaccis\Stemmer\Adapter\Libstemmer;
use Amaccis\Stemmer\Enum\CharacterEncodingEnum;
use Amaccis\Stemmer\Exception\UnavailableAlgorithmException;
use FFI;
use FFI\CData;

class Stemmer implements StemmerInterface
{

    private const HEADER_PATH = __DIR__ . '/../resources/libstemmer.h';

    private Libstemmer $libstemmer;

    private CData $stemmer;

    /**
     * @param string $algorithm
     * @param CharacterEncodingEnum $charenc
     * @throws UnavailableAlgorithmException
     */
    public function __construct(string $algorithm, CharacterEncodingEnum $charenc = CharacterEncodingEnum::UTF_8)
    {

        $this->libstemmer = new Libstemmer(self::HEADER_PATH);
        $this->stemmer = $this->libstemmer->sbStemmerNew($algorithm, $charenc);

    }

    public static function algorithms(): array
    {

        $libstemmer = new Libstemmer(self::HEADER_PATH);
        /** @var array $stemmerList */
        $stemmerList = $libstemmer->sbStemmerList();
        $algorithms = [];
        $i = 0;
        while ($stemmerList[$i] != NULL) {
            $algorithms[] = $stemmerList[$i];
            $i++;
        }

        return $algorithms;

    }

    public function stemWord(string $word): string
    {

        $size = strlen($word);
        $stem = $this->libstemmer->sbStemmerStem($this->stemmer, $word, $size);
        $size = $this->libstemmer->sbStemmerLength($this->stemmer);

        return FFI::string($stem, $size);

    }

    public function stemWords(array $words): array
    {

        $stems = [];
        foreach ($words as $word) {
            $stems[] = $this->stemWord($word);
        }

        return $stems;

    }

}