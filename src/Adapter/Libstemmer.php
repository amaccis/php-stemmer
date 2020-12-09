<?php
declare(strict_types=1);

/**
 * @author Andrea Maccis <andrea.maccis@gmail.com>
 */

namespace Amaccis\Stemmer\Adapter;

use FFI;
use FFI\CData;

final class Libstemmer
{

    private const HEADER = 'libstemmer.h';

    private const CHARSET = 'UTF_8';

    private FFI $ffi;

    public function __construct()
    {

        $this->ffi = \FFI::load(__DIR__ . '/../../resources/' . self::HEADER);

    }

    public function sbStemmerNew(string $algorithm): CData
    {

        return $this->ffi->sb_stemmer_new($algorithm, self::CHARSET);

    }

    public function sbStemmerList(): CData
    {

        return $this->ffi->sb_stemmer_list();

    }

    public function sbStemmerStem(CData $sbStemmer, string $word): CData
    {

        $size = strlen($word);
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

    public function toString(CData $memoryArea, int $size): string
    {

        return FFI::string($memoryArea, $size);

    }

}