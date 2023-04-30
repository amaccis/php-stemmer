<?php
declare(strict_types=1);

namespace Amaccis\Stemmer\Adapter;

use Amaccis\Stemmer\Enum\CharacterEncodingEnum;
use Amaccis\Stemmer\Exception\UnavailableAlgorithmException;
use FFI;
use FFI\CData;

final class Libstemmer
{

    private FFI $ffi;

    public function __construct(string $filename)
    {

        $this->ffi = \FFI::load($filename);

    }

    /**
     * @throws UnavailableAlgorithmException
     */
    public function sbStemmerNew(string $algorithm, CharacterEncodingEnum $charenc): CData
    {

        $sbStemmer = $this->ffi->sb_stemmer_new($algorithm, $charenc->name);
        if (is_null($sbStemmer)) {
            throw new UnavailableAlgorithmException();
        }
        return $sbStemmer;

    }

    public function sbStemmerList(): CData
    {

        return $this->ffi->sb_stemmer_list();

    }

    public function sbStemmerDelete(CData $sbStemmer): void
    {

        $this->ffi->sb_stemmer_delete($sbStemmer);

    }

    public function sbStemmerStem(CData $sbStemmer, string $word, int $size): CData
    {

        $c_word = FFI::new("char[$size]");
        FFI::memcpy($c_word, $word, $size);
        $sb_symbol = FFI::cast($this->ffi->type('sb_symbol'), $c_word);
        $word = FFI::addr($sb_symbol);

        return $this->ffi->sb_stemmer_stem($sbStemmer, $word, $size);

    }

    public function sbStemmerLength(CData $sbStemmer): int
    {

        return $this->ffi->sb_stemmer_length($sbStemmer);

    }

}