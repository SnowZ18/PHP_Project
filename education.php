<?php


require_once("functions.php");
require_once("classes.php");

// ax + b = 0
function line($a = 0, $b = 0)
{
    if (is_numeric($a) && is_numeric($b)) {
        if ($a != 0) {
            return [-$b / $a];
        }
    }
    return [];
}

// ax^2 + bx + c = 0
function square($a = 0, $b = 0, $c = 0)
{
    if (is_numeric($a) && is_numeric($b) && is_numeric($c)) {
        if ($a === 0) {
            return line($b, $c);
        } else {
            $D = $b ** 2 - 4 * $a * $c;
            if ($D < 0) {
                return [];
            } elseif ($D === 0) {
                return [-$b / (2 * $a)];
            } else {
                return [(-$b - sqrt($D)) / (2 * $a), (-$b + sqrt($D)) / (2 * $a)];
            }
        }
    }
}

// ax^3 + bx^2 + cx + d = 0
function cubic($num1 = 0, $num2 = 0, $num3 = 0, $num4 = 0)
{
    if (is_numeric($num1) && is_numeric($num2) && is_numeric($num3) && is_numeric($num4)) {
        if ($num1 === 0) {
            return [(square($num1, $num2, $num3))];
        } else {
            $a = $num2 / $num1;
            $b = $num3 / $num1;
            $c = $num4 / $num1;

            $Q = ($a ** 2 - 3 * $b) / 9;
            $R = (2 * $a ** 3 - 9 * $a * $b + 27 * $c) / 54;
            $S = $Q ** 3 - $R ** 2;

            if ($S > 0) {
                $fi = acos($R / pow($Q, 3 / 2)) / 3;

                $x1 = -2 * sqrt($Q) * cos($fi) - $a / 3;
                $x2 = -2 * sqrt($Q) * cos($fi + 2 * pi() / 3) - $a / 3;
                $x3 = -2 * sqrt($Q) * cos($fi - 2 * pi() / 3) - $a / 3;

                return [
                    "x1" => "$x1 <br>",
                    "x2" => "$x2 <br>",
                    "x3" => "$x3 <br>"
                ];
            } elseif ($S < 0) {
                if ($Q > 0) {
                    $compNum1 = new complex;
                    $compNum2 = new complex;
                    $fi = 1 / 3 * acosh(abs($R) / pow($Q, 3 / 2));

                    $x1 = -2 * sgn($R) * sqrt($Q) * cosh($fi) - $a / 3;
                    $compNum1->real = sgn($R) * sqrt($Q) * cosh($fi) - $a / 3;
                    $compNum1->im = sqrt(3) * sqrt($Q) * sinh($fi);
                    $compNum2->real = sgn($R) * sqrt($Q) * cosh($fi) - $a / 3;
                    $compNum2->im = -sqrt(3) * sqrt($Q) * sinh($fi);

                    return [
                        "x1" => "$x1 <br>",
                        "x2" => $compNum1, "<br>",
                        "x3" => $compNum2, "<br>"
                    ];
                } elseif ($Q < 0) {
                    $compNum1 = new complex;
                    $compNum2 = new complex;
                    $fi = asinh(abs($R) / pow(abs($Q), 3 / 2)) / 3;

                    $x1 = -2 * sgn($R) * sqrt(abs($Q)) * sinh($fi) - $a / 3;
                    $compNum1->real = sgn($R) * sqrt(abs($Q)) * sinh($fi) - $a / 3;
                    $compNum1->im = sqrt(3) * sqrt(abs($Q)) * cosh($fi);
                    $compNum2->real = sgn($R) * sqrt(abs($Q)) * sinh($fi) - $a / 3;
                    $compNum2->im = -sqrt(3) * sqrt(abs($Q)) * cosh($fi);

                    return [
                        "x1" => "$x1 <br>",
                        "x2" => $compNum1, "<br>",
                        "x3" => $compNum2, "<br>"
                    ];
                } elseif ($Q === 0) {
                    $compNum1 = new complex;
                    $compNum2 = new complex;

                    $x1 = -pow($c - $a ** 3 / 27, 1 / 3) - $a / 3;
                    $compNum1->real = -($a + $x1) / 2;
                    $compNum1->im = sqrt(abs(($a - 3 * $x1) * ($a + $x1) - 4 * $b)) / 2;
                    $compNum2->real = -($a + $x1) / 2;
                    $compNum2->im = -sqrt(abs(($a - 3 * $x1) * ($a + $x1) - 4 * $b)) / 2;

                    return [
                        "x1" => "$x1 <br>",
                        "x2" => $compNum1, "<br>",
                        "x3" => $compNum2, "<br>"
                    ];
                } else {
                    return ["Q is NaN"];
                }
            } elseif ($S === 0) {
                $x1 = -2 * pow($R, 1 / 3) - $a / 3;
                $x2 = pow($R, 1 / 3) - $a / 3;

                return [
                    "x1" => "$x1 <br>",
                    "x2" => "$x2 <br>"
                ];
            } else {
                return ["S is NaN"];
            }
        }
    }
}

function integral($func = null, $a = 0, $b = 0, $eps = 0.0001)
{
    $S = 0;
    eval("\$func = function(\$x = 0) { return $func; };");
    for ($i = $a; $i < $b; $i += $eps) {
        $S += abs($eps * $func($i));
    }
    return [$S];
}

function volumeRotation($func = null, $a = 0, $b = 0, $eps = 0.0001)
{
    $S = 0;
    eval("\$func = function(\$x = 0) { return $func; };");
    for ($i = $a; $i < $b; $i += $eps) {
        $S += $eps * $func($i) ** 2 * pi();
    }
    return [$S];
}