<?php

declare(strict_types=1);

namespace Phanalysis\Checkers;

use Phanalysis\Result;
use PhpParser\Node;

interface CheckerInterface
{
    public function applies(Node $node): bool;

    public function check(Node $node): ?Result;
}
