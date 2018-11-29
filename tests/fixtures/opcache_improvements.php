<?php

namespace test;

// When in a namespace, opcache improvements can be made using fully qualified
// function calls https://github.com/Roave/FunctionFQNReplacer
function opcache_improvements() {
  $array = [1,2,3,4,5];
  $count = count($array);
}

function opcache_improvements_ffqn() {
  $array = [1,2,3,4,5];
  $count = \count($array);
}
