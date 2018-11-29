<?php

declare(strict_types=1);

namespace Phanalysis\Tests;

use Phanalysis\Checkers\SingleQuoteChecker;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar\String_;
use PHPUnit\Framework\TestCase;

class SingleQuoteCheckerTest extends TestCase {
  public function testChecker(): void {
    $checker = new SingleQuoteChecker();

    $single_quoted_strng_node = $this->prophesize(String_::class);
    $single_quoted_strng_node->getAttribute('kind')->willReturn(String_::KIND_SINGLE_QUOTED);
    $this->assertTrue($checker->applies($single_quoted_strng_node->reveal()));
    $this->assertEmpty($checker->check($single_quoted_strng_node->reveal()));

    $func_call_node = $this->prophesize(FuncCall::class);
    $this->assertFalse($checker->applies($func_call_node->reveal()));

    $double_quoted_string_node = $this->prophesize(String_::class);
    $double_quoted_string_node->getAttribute('kind')->willReturn(String_::KIND_DOUBLE_QUOTED);
    $double_quoted_string_node->getLine()->willReturn(10);

    $this->assertTrue($checker->applies($double_quoted_string_node->reveal()));
    $result = $checker->check($double_quoted_string_node->reveal());
    $this->assertNotEmpty($result);

    $this->assertEquals(
      '10: Safely use single quotes instead',
      $result->getMessage()
    );
  }
}
