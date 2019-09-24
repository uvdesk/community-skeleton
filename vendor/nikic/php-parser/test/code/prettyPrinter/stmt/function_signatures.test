Function signatures
-----
<?php

interface A
{
    function f1();
    function f2($a, $b);
    function f3(&$a);
    function f4(A\B $a);
    function f4(array $a);
    function f5(callable $a);
    function f6(&$a);
    function f7(...$a);
    function f8(&...$a);
    function f9(A &$a);
    function f10(A ...$a);
    function f11(A &$a);
    function f12(A &...$a);
    function f13($a) : array;
    function f14($a) : callable;
    function f15($a) : B\C;
}
-----
interface A
{
    function f1();
    function f2($a, $b);
    function f3(&$a);
    function f4(A\B $a);
    function f4(array $a);
    function f5(callable $a);
    function f6(&$a);
    function f7(...$a);
    function f8(&...$a);
    function f9(A &$a);
    function f10(A ...$a);
    function f11(A &$a);
    function f12(A &...$a);
    function f13($a) : array;
    function f14($a) : callable;
    function f15($a) : B\C;
}
