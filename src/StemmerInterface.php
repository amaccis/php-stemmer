<?php
declare(strict_types=1);

namespace Amaccis\Stemmer;

interface StemmerInterface
{

    /**
     * @return string[]
     */
    public static function algorithms(): array;

    public function stemWord(string $word): string;

    /**
     * @param string[] $words
     * @return string[]
     */
    public function stemWords(array $words): array;

}