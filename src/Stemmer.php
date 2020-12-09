<?php
declare(strict_types=1);

/**
 * @author Andrea Maccis <andrea.maccis@gmail.com>
 */

namespace Amaccis\Stemmer;

use Amaccis\Stemmer\Adapter\Libstemmer;
use FFI\CData;

class Stemmer implements StemmerInterface
{

    private Libstemmer $libstemmer;

    private CData $stemmer;

    private string $algorithm;

    public function __construct(string $algorithm)
    {

        $this->libstemmer = new Libstemmer();
        $this->stemmer = $this->libstemmer->sbStemmerNew($algorithm);
        $this->algorithm = $algorithm;

    }

    public static function algorithms(): array
    {

        $libstemmer = new Libstemmer();
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

        $stem = $this->libstemmer->sbStemmerStem($this->stemmer, utf8_encode($word));
        $size = $this->libstemmer->sbStemmerLength($this->stemmer);

        return $this->libstemmer->toString($stem, $size);

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