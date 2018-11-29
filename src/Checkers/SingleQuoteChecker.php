<?php

declare(strict_types=1);

namespace Phanalysis\Checkers;

use Phanalysis\Result;
use PhpParser\Node;
use PhpParser\Node\Scalar\String_;

class SingleQuoteChecker implements CheckerInterface {

  public function applies(Node $node): bool {
    return $node instanceof String_;
  }

  public function check(Node $node): ?Result {
      \assert($node instanceof String_);
      if ($node->getAttribute('kind') === String_::KIND_DOUBLE_QUOTED) {
        return new Result('Safely use single quotes instead');
      }
  }

}
