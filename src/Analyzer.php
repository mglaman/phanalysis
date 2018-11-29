<?php

declare(strict_types=1);

namespace Phanalysis;

use Phanalysis\Checkers\ChainedChecker;
use PhpParser\Node;

class Analyzer {

  private $chainChecker;
  private $sourceFile;
  private $results = [];

  public function __construct(SourceFile $sourceFile) {
    $this->chainChecker = new ChainedChecker();
    $this->sourceFile = $sourceFile;
  }

  public function inspect(): array {
    $this->inspectStatements($this->sourceFile->getStatements());
    return $this->results;
  }

  /**
   * @param \PhpParser\Node\Stmt[] $statements
   */
  protected function inspectStatements(array $statements): void {
    foreach ($statements as $statement) {
      $this->inspectStatement($statement);
    }
  }

  protected function inspectStatement(Node\Stmt $stmt): void {
    if ($stmt instanceof Node\Stmt\Function_) {
      $this->inspectFunction($stmt);
    }
    elseif ($stmt instanceof Node\Stmt\Expression) {
      $this->inspectExpression($stmt->expr);
    }
  }

  protected function inspectFunction(Node\Stmt\Function_ $function_): void {
    $this->inspectStatements($function_->getStmts());
  }

  protected function inspectExpression(Node\Expr $expression): void {
    if ($expression instanceof Node\Expr\Print_) {
      $this->inspectNode($expression->expr);
    }
  }

  protected function inspectNode(Node $node): void {
    $results = $this->chainChecker->check($node);
    $this->results = array_merge($this->results, $results);
  }
}
