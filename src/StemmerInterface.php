<?php
declare(strict_types=1);

/**
 * @author Andrea Maccis <andrea.maccis@gmail.com>
 */

namespace Amaccis\Stemmer;


interface StemmerInterface
{

    public static function algorithms(): array;

    public function stemWord(string $word): string;

    public function stemWords(array $words): array;

}