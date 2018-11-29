<?php

declare(strict_types=1);

namespace Phanalysis;

use PhpParser\ParserFactory;

final class Parser
{
    private $parser;

    public function __construct()
    {
        $this->parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
    }

    public function parseFile(string $path): SourceFile
    {
        return new SourceFile($path, $this->parser);
    }
}
