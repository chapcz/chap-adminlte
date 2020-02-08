<?php declare(strict_types=1);

namespace Chap\AdminLTE\Components\ActionButtons;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;

class ActionButtons extends Control
{
    /** @var Button[]  */
    private $buttons = [];

    /** @var DropLink[]  */
    private $dropLinks = [];

    /**
     * @param Button $button
     */
    public function addButton(Button $button): void
    {
        $this->buttons[] = $button;
    }

    /**
     * @param DropLink $dropLink
     */
    public function addDropdownLink(DropLink $dropLink): void
    {
        $this->dropLinks[] = $dropLink;
    }

    public function render(): void
    {
        /** @var Template $template */
        $template = $this->getTemplate();
        $template->render(__DIR__ . DIRECTORY_SEPARATOR . 'template.latte', [
            'buttons' => $this->buttons,
            'dropLinks' => $this->dropLinks,
        ]);
    }
}
