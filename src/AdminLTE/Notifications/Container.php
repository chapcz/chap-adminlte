<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

use Nette\Application\UI\Control;
use Nette\ComponentModel\IComponent;

class Container extends Control
{
    /** @var IPanel[] */
    private $panels;

    /**
     * @param IPanel $panel
     * @return Container
     */
    public function addPanel(IPanel $panel): self
    {
        $this->panels[] = $panel;
        if ($panel instanceof IComponent) {
            $this->addComponent($panel, sprintf('panel%d',\count($this->panels)));
        }

        return $this;
    }

    public function render(): void
    {
        foreach ($this->panels as $panel) {
            $panel->render();
        }
    }
}
