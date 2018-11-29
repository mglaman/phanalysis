<?php

namespace Phanalysis;

final class Result {
  private $message;
  private $line;
  public function __construct(string $message, int $line) {
    $this->message = $message;
    $this->line = $line;
  }

  public function getMessage(): string {
    return sprintf('%s: %s', $this->line, $this->message);
  }

  public function __toString() {
    return $this->getMessage();
  }
}
