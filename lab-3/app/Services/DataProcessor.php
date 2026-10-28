<?php declare(strict_types=1);

namespace App\Services;

class DataProcessor
{
    /**
     * Перевіряє, чи всі елементи масиву менші за K.
     *
     * @param array<int, int> $numbers
     */
    public function areAllLessThan(array $numbers, int $k): bool
    {
        foreach ($numbers as $number) {
            if ($number >= $k) {
                return false;
            }
        }

        return true;
    }

    /**
     * Міняє місцями перше й останнє слова.
     */
    public function swapFirstAndLastWord(string $text): string
    {
       $words = preg_split('/\s+/', trim($text));

        if ($words === false || count($words) < 2) {
            return $text;
        }

        $lastIndex = count($words) - 1;
        [$words[0], $words[$lastIndex]] = [$words[$lastIndex], $words[0]];

        return implode(' ', $words);
    }

    /**
     * Перемішує слова в рядку у випадковому порядку.
     */
    public function shuffleWords(string $text): string
    {
        $text = trim($text);

        if ($text === '') {
            return '';
        }

        $words = preg_split('/\s+/', trim($text));

        if ($words === false) {
            return $text;
        }

        shuffle($words);

        return implode(' ', $words);
    }
}
