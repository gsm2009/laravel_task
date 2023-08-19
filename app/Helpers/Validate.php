<?php

/*
 * 判断括号是否有效
 */
if (!function_exists('IsValidBracket')) {
    function IsValidBracket($s)
    {
        $len = strlen($s);
        //判断字符串长度
        if ($len < 1 || $len > 10000) {
            return false;
        }
        $stack = [];
        $map = [
            ')' => '(',
            '}' => '{',
            ']' => '['
        ];

        for ($i = 0; $i < strlen($s); $i++) {
            $char = $s[$i];
            //判断$s是否包含别的字符
            if (!isset($map[$char]) && !in_array($char, $map)) {
                return false;
            }

            if (!in_array($char, $map)) {
                $topElement = (!empty($stack)) ? array_pop($stack) : '#';
                if ($map[$char] != $topElement) {
                    return false;
                }
            } else {
                array_push($stack, $char);
            }
        }
        return empty($stack);
    }
}