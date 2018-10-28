<?php declare(strict_types=1);

namespace Chap\AdminLTE\Menu;

use Nette\Application\UI\Component;

interface IMenuControlFactory
{
    /**
     * @param array     $menuStructure
     * @param Component $parent
     * @return MenuControl
     */
    public function create(array $menuStructure, Component $parent): MenuControl;
}
