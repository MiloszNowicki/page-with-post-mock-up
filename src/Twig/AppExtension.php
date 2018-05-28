<?php
/**
 * Created by PhpStorm.
 * User: milosz
 * Date: 28.05.18
 * Time: 11:29
 */

namespace App\Twig;

use App\Utils\Markdown;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('md2html', [$this, 'markdownToHtml'], [
                'is_safe' => ['html'],
                'pre_escape' => 'html',
            ]),
        ];
    }

    public function markdownToHtml($content)
    {
        return $this->parser->toHtml($content);
    }
}