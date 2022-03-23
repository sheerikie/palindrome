<?php

namespace App\Service;

use Doctrine\DBAL\Driver\Connection;
use App\Service\PalindromeService;

class HighlightService
{


    /**
     * Receives text/words and returns highlighted data
     * @param string $filename string
     * @param string $palindrome string
     * @return array array $highlight|null
     */
    public function highlight($filename, $palindromes)
    {
        $text= file_get_contents($filename);
    
        //regex highlights palindrome from text
        preg_match_all('~\w+~', $palindromes, $m);
        if (!$m) {
            return $text;
        }
        $re = '~\\b(' . implode('|', $m[0]) . ')\\b~';
        return preg_replace($re, '<i><b>$0</b></i>', $text);
    }
}