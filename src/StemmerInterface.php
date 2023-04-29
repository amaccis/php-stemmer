<?php
declare(strict_types=1);

namespace Amaccis\Stemmer;

interface StemmerInterface
{

    public static function algorithms(): array;

    public function stemWord(string $word): string;

    public function stemWords(array $words): array;

}