<?php

declare(strict_types=1);

namespace Phanalysis;

use Phanalysis\Exception\InvalidSourceFileException;
use PhpParser\Node;

final class SourceFile {

    private $path;

    /** @var \PhpParser\Node\Stmt[]  */
    private $statements;

    public function __construct(string $path, \PhpParser\Parser $parser) {
      if (!file_exists($path)) {
        throw new InvalidSourceFileException('Cannot open file ' . $path);
      }

      $this->path = $path;
      $this->statements = $parser->parse(file_get_contents($this->getPath()));
    }

    public function getPath(): string {
      return $this->path;
    }

  /**
   * @return \PhpParser\Node\Stmt[]
   */
    public function getStatements(): array {
      return $this->statements;
    }

}
