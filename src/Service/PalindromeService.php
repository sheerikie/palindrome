<?php

namespace App\Service;

use Doctrine\DBAL\Driver\Connection;

class PalindromeService
{

    /**
     * Returns Palindrome list
     *
     * @param string $content Content string
     * @return array array $palindromes|null
     */
    private function calculatePalindrome($content)
    {
        $count=0;
        $palindromes=array();
        $string = str_replace(' ', '', $content);
        //change case to lower
        $string = strtolower($string);
        //split the string to array
        $word=explode(",", $string);
        $word=explode(",", $string);
        
        foreach ($word as $val) {
            //remove special characters
            $val = preg_replace('/[^A-Za-z0-9\-]/', '', $val);
            if ($val==strrev($val)) {
                if (!in_array($val, $palindromes)) {
                    array_push($palindromes, $val);
                    $count++;
                }
            }
        }
        $decoded=json_decode(json_encode($palindromes), true);
        $palindrome=implode(",", $decoded);
        return $palindrome;
    }
    
    /**
     * Receives filename/path and returns list of palindromes from filecontents
     *
     * @param string $filename string
     * @return array array $palindrome|null
     */
    public function doRequest($filename)
    {
        $content="";
        if (!file_exists($filename)) {
            return new Response('File not found', 404, []);
        }
        $content= file_get_contents($filename);
        $palindrome=$this->calculatePalindrome($content);
        return $palindrome;
    }
}