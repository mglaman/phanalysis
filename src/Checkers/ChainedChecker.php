<?php

declare(strict_types=1);

namespace Phanalysis\Checkers;

use PhpParser\Node;

class ChainedChecker {
  /** @var \Phanalysis\Checkers\CheckerInterface[]  */
  private $checkers = [];

  public function __construct() {
    $this->checkers[] = new SingleQuoteChecker();
    $this->checkers[] = new FunctionFullyQualifiedNameChecker();
  }

  public function check(Node $node): array {
    $results = [];
    foreach ($this->checkers as $checker) {
      if ($checker->applies($node)) {
        $results[] = $checker->check($node);
      }
    }

    return $results;
  }
}
