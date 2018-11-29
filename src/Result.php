<?php

namespace Phanalysis;

final class Result {
  private $message;
  public function __construct(string $message) {
    $this->message = $message;
  }

  public function getMessage(): string {
    return $this->message;
  }

  public function __toString() {
    return $this->getMessage();
  }
}
