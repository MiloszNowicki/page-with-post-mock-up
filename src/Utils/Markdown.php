<?php
/**
 * Created by PhpStorm.
 * User: milosz
 * Date: 28.05.18
 * Time: 11:24
 */

namespace App\Utils;


class Markdown
{
    // ...


    public function toHtml(string $text): string
    {
        return $this->parser->text($text);
    }
}