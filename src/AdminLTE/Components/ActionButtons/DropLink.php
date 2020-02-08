<?php declare(strict_types=1);

namespace Chap\AdminLTE\Components\ActionButtons;

class DropLink
{
    /** @var string */
    public $link;
    /** @var string */
    public $caption;

    /**
     * @param string $link
     * @param string $caption
     */
    public function __construct(string $link, string $caption)
    {
        $this->link = $link;
        $this->caption = $caption;
    }
}
