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
        $val = strtolower($string);
        //split the string to array
      
        //remove special characters
        $subs = preg_replace('/[^A-Za-z0-9\-]/', '', $val);
 
      

        $len = strlen($subs);
        $tmps = '';
        $max = 0;
       
        for ($i = 0; $i< $len-1; $i++) {
            // starting subscript
            for ($j = $i + 1; $j <= $len; $j++) {// length
                if ($this->isPalindrome(substr($subs, $i, $j)) && $j > $max) {
                    $tmps = substr($subs, $i, $j);
                    $max = $j;
                }
            }
        
            if (strlen($tmps)>1 && !in_array($tmps, $palindromes)) {
                array_push($palindromes, $tmps);
                $count++;
            }
        }
   
    
        $decoded=json_decode(json_encode($palindromes), true);
        $palindrome=implode(" ", $decoded);
        
        return [$palindrome,$count];
    }
    /**
     * Receives substring and returns boolean
     *
     * @param string $subs string
     * @return boolean bool
     */
    public function isPalindrome($subs)
    {
        $len = strlen($subs);
        for ($i=0; $i<(int)($len/2); $i++) {
            if ($subs[$i] != $subs[$len-$i-1]) {
                return false;
            }
        }
        return true;
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