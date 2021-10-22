<?php

namespace Aloefflerj\FedTheDog\Controller\Helpers;

trait StringHelper
{
    /**
     * Returns equal parts of string until encounters something different
     *
     * @param string $string1
     * @param string $string2
     * @return string|null
     */
    public function stringCompare(string $string1, string $string2): ?string
    {
        $charArray1 = str_split($string1);
        $charArray2 = str_split($string2);

        $sameChar = [];

        foreach ($charArray1 as $key => $charElement1) {
            if($charElement1 === $charArray2[$key]) {
                $sameChar[] = $charElement1;
            }else {
                break;
            }
        }

        if(empty($sameChar)) {
            return null;
        }
        
        $same = implode("", $sameChar);

        return $same;
    }
}