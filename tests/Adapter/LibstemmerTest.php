<?php
declare(strict_types=1);

namespace Amaccis\Stemmer\Tests\Adapter;

use Amaccis\Stemmer\Adapter\Libstemmer;
use PHPUnit\Framework\TestCase;
use FFI\Exception;

class LibstemmerTest extends TestCase
{

    public function testThatStemmerWithUnavailableAlgorithmThrowsException(): void
    {

        $this->expectException(Exception::class);
        $filename = "filethatdoesnotexist.h";
        new Libstemmer($filename);

    }

}



