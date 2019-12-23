<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

use Nette\Utils\Html;

class CustomPanel extends BasePanel
{
    /**
     * @param string $string
     * @return CustomPanel
     */
    public function addString(string $string): self
    {
        $this->addItem((new Html())->setHtml($string));

        return $this;
    }

    /**
     * @param Html<string, mixed> $html
     * @return CustomPanel
     */
    public function addHtml(Html $html): self
    {
        $this->addItem((new Html())->setHtml($html));

        return $this;
    }
}
