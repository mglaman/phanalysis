<?php

declare(strict_types=1);

namespace Phanalysis\Tests\Checkers;

use Phanalysis\Checkers\FunctionFullyQualifiedNameChecker;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\String_;
use PHPUnit\Framework\TestCase;

class FunctionFullyQualifiedNameCheckerTest extends TestCase {
  public function testChecker(): void {
    $checker = new FunctionFullyQualifiedNameChecker();

    $string_node = $this->prophesize(String_::class);
    $this->assertFalse($checker->applies($string_node->reveal()));

    $unqualified_func_call = new FuncCall(new Name('funcName'), [], ['startLine' => 10]);

    $this->assertTrue($checker->applies($unqualified_func_call));
    $result = $checker->check($unqualified_func_call);

    $this->assertEquals(
      '10: Use fully qualified name for better opcache performance. Replace with \\funcName',
      $result->getMessage()
    );

    $unqualified_func_call = new FuncCall(new FullyQualified('funcName'), [], ['startLine' => 10]);

    $this->assertTrue($checker->applies($unqualified_func_call));
    $this->assertNull($checker->check($unqualified_func_call));
  }
}
