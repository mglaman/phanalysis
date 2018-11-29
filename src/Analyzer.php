<?php

declare(strict_types=1);

namespace Phanalysis;

use Phanalysis\Checkers\ChainedChecker;
use PhpParser\Node;

class Analyzer
{

    private $chainChecker;
    private $sourceFile;
    private $results = [];

    public function __construct(SourceFile $sourceFile)
    {
        $this->chainChecker = new ChainedChecker();
        $this->sourceFile = $sourceFile;
    }

    public function inspect(): array
    {
        $this->inspectStatements($this->sourceFile->getStatements());
        return $this->results;
    }

    /**
     * @param \PhpParser\Node\Stmt[] $statements
     */
    protected function inspectStatements(array $statements): void
    {
        foreach ($statements as $statement) {
            $this->inspectStatement($statement);
        }
    }

    protected function inspectStatement(Node\Stmt $stmt): void
    {
        if ($stmt instanceof Node\Stmt\Function_) {
            $this->inspectStatements($stmt->stmts);
        } elseif ($stmt instanceof Node\Stmt\Namespace_) {
            $this->inspectStatements($stmt->stmts);
        } elseif ($stmt instanceof Node\Stmt\Expression) {
            $this->inspectExpression($stmt->expr);
        } elseif ($stmt instanceof Node\Stmt\If_) {
            $this->inspectExpression($stmt->cond);
            $this->inspectStatements($stmt->stmts);
        } elseif ($stmt instanceof Node\Stmt\ElseIf_) {
            $this->inspectExpression($stmt->cond);
            $this->inspectStatements($stmt->stmts);
        }
    }

    protected function inspectExpression(Node\Expr $expression): void
    {
        if ($expression instanceof Node\Expr\Print_) {
            $this->inspectNode($expression->expr);
        } elseif ($expression instanceof Node\Expr\Assign) {
            $this->inspectNode($expression->var);
            $this->inspectExpression($expression->expr);
        } elseif ($expression instanceof Node\Expr\FuncCall) {
            $this->inspectNode($expression);
        } elseif ($expression instanceof Node\Expr\BinaryOp) {
            $this->inspectNode($expression->left);
            $this->inspectNode($expression->right);
        }
    }

    protected function inspectNode(Node $node): void
    {
        $results = $this->chainChecker->check($node);
        $this->results = array_filter(array_merge($this->results, $results));
    }
}
