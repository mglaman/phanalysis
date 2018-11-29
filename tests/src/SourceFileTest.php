<?php

declare(strict_types=1);

namespace Phanalysis\Tests;

use Phanalysis\Exception\InvalidSourceFileException;
use Phanalysis\SourceFile;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Phanalysis\SourceFile
 */
class SourceFileTest extends TestCase {
  public function testInvalidPathException(): void {
    $parser = $this->prophesize(Parser::class);
    $this->expectException(InvalidSourceFileException::class);
    new SourceFile('/fake/path.php', $parser->reveal());
  }

  public function testSourceFile(): void {
    $file = __DIR__ . '/../fixtures/hello.php';
    $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

    $source_file = new SourceFile($file, $parser);

    $this->assertEquals($file, $source_file->getPath());
    $this->assertNotEmpty($source_file->getStatements());
  }
}
