<?php

namespace App\Custom;


class TokenMaker
{
    static function make()
    {
        $token = '';

        $letters = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm',
               'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'O', 'P', 'S', 'D', 'f', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
        $symbols = ['1', '@', '#', '$', '%', '^', '&', '*', '(', ')', '{', '}', '[', ']'];
        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

        $length = 20;
        $lengthLetters = rand(1, 10);
        $lengthNumbers = rand(1, $length - $lengthLetters);
        $lengthSymbols = $length - $lengthLetters - $lengthNumbers + 3;

        while ($lengthLetters > 0)
        {
            $token .= $letters[rand(0, count($letters)-1)];
            $lengthLetters -= 1;
        }
    
        while ($lengthSymbols > 0)
        {
            $token .= $symbols[rand(0, count($symbols)-1)];
            $lengthSymbols -= 1;
        }
    
        while ($lengthNumbers > 0)
        {
            $token .= $numbers[rand(0, count($numbers)-1)];
            $lengthNumbers -= 1;
        }

        return $token;
    }
}