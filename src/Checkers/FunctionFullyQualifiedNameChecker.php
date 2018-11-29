<?php

declare(strict_types=1);

namespace Phanalysis\Checkers;

use Phanalysis\Result;
use PhpParser\Node;

class FunctionFullyQualifiedNameChecker implements CheckerInterface {

  public function applies(Node $node): bool {
    return $node instanceof Node\Expr\FuncCall;
  }

  public function check(Node $node): ?Result {
    \assert($node instanceof Node\Expr\FuncCall);

    if ($node->name instanceof Node\Name\FullyQualified) {
      return null;
    }

    // @todo this should only fire if the parent node is in a namespace.
    return new Result(
      'Functions should use their fully qualified name for better opcache performance. Replace with \\' . $node->name,
      $node->getLine()
    );
  }

}
