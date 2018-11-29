<?php

declare(strict_types=1);

namespace Phanalysis\Tests;

use Phanalysis\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase {
  public function testParser(): void {
    $parser = new Parser();

    $file = __DIR__ . '/../fixtures/hello.php';
    $source_file = $parser->parseFile($file);

    $this->assertEquals($file, $source_file->getPath());
    $this->assertNotEmpty($source_file->getStatements());
  }
}
