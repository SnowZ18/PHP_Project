<?php

// function return 1, -1 or 0 like func sgn in math,
// if value is not a number, then return null
function sgn($value)
{
    if (is_numeric($value)) {
        if ($value > 0) {
            return 1;
        } elseif ($value < 0){
                return -1;
 } else {
            return 0;
        }
 } else {
        return null;
    }
}