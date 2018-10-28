<?php declare(strict_types=1);

namespace Chap\AdminLTE\Menu;

use Chap\AdminLTE\DummyTranslator;
use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Component;
use Nette\Application\UI\Control;
use Nette\Application\UI\InvalidLinkException;
use Nette\Security\User;

class MenuControl extends Control
{
    /** @var Item[]  */
    private $allItems = [];

    /**
     * @var Item[]
     */
    private $tree = [];

    /**
     * @var Item
     */
    private $current;

    /**
     * @param array     $menuStructure
     * @param Component $parent
     * @param User      $user
     * @throws ForbiddenRequestException
     */
    public function __construct(array $menuStructure, Component $parent, User $user)
    {
        parent::__construct();

        foreach ($menuStructure as $values) {
            $this->tree[] = new Item($values, $user);
        }
        $this->flatten($this->tree);
        $presenter = $parent->getPresenter(false);
        if ($presenter === null) {
            return;
        }
        foreach ($this->allItems as $item) {
            try {
                if ($item->link !== null && $presenter->isLinkCurrent($item->link) === true) {
                    $item->isCurrent = true;
                    $this->current = $item;
                    if ($this->current->allowed === false) {
                        throw new ForbiddenRequestException('This view is not allowed');
                    }
                    break;
                }

            } catch (InvalidLinkException $e) {}
        }
    }

    /**
     * @param Item[] $items
     */
    private function flatten(array $items): void
    {
        foreach ($items as $item) {
            if (array_key_exists($item->link, $this->allItems) === false) {
                $this->allItems[$item->link] = $item;
            }
        }
        foreach ($items as $item) {
            if ($item->items !== null) {
                $this->flatten($item->items);
            }
        }
    }

    public function renderMenu(): void
    {
        DummyTranslator::initEmpty($this->createTemplate())
            ->render(__DIR__ . '/navigation.latte', ['tree' => $this->tree]);
    }

    public function renderBreadcrumb(): void
    {
        DummyTranslator::initEmpty($this->createTemplate())
            ->render(__DIR__ . '/breadcrumb.latte', ['current' => $this->current]);
    }
}
