<?php declare(strict_types=1);

namespace Chap\AdminLTE\Menu;

use Nette\Security\User;

class Item
{
    /**
     * @var Item[]|null
     */
    public $items;

    /**
     * @var Item[]|null
     */
    public $shownItems;

    /**
     * @var Item|null
     */
    public $parent;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $subTitle;

    /**
     * @var string
     */
    public $link;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string|null
     */
    public $resource;

    /**
     * @var string|null
     */
    public $privilege;

    /**
     * @var string|null
     */
    public $role;

    /**
     * @var bool
     */
    public $isCurrent = false;

    /**
     * @var bool
     */
    public $shown = true;

    /**
     * @var bool
     */
    public $allowed = true;

    /**
     * @param array     $values
     * @param User      $user
     * @param Item|null $parent
     */
    public function __construct(array $values, User $user, ?Item $parent = null)
    {
        $this->name = $values['name'];
        $this->link = $values['link'] ?? null;
        $this->subTitle = $values['subTitle'] ?? null;
        $this->shown = $values['show'] ?? true;
        $this->icon = $values['icon'];
        $this->resource = $values['resource'] ?? null;
        $this->privilege = $values['privilege'] ?? null;
        $this->items = [];
        $this->shownItems = [];
        $this->allowed = $this->checkPermission($user, $values);
        $this->parent = $parent;
        foreach ($values['items'] ?? [] as $value) {
            $item = new Item($value, $user, $this);
            $this->items[] = $item;
            if ($item->shown) {
                $this->shownItems[] = $item;
            }
        }
    }

    /**
     * @param User  $user
     * @param array $values
     * @return bool
     */
    private function checkPermission(User $user, array $values): bool
    {
        if ($user->getAuthorizator(false) === null) {
            return true;
        }
        $role = $values['role'] ?? null;
        $resource = $values['resource'] ?? null;
        $privilege = $values['privilege'] ?? null;

        if ($resource !== null && $user->isAllowed($resource, $privilege) === false) {
            return false;
        }
        if ($role !== null && $user->isInRole($values['role']) === false) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isCurrent(): bool
    {
        if ($this->isCurrent === true) {
            return true;
        }
        if ($this->items !== null) {
            foreach ($this->items as $item) {
                if ($item->isCurrent() === true) {
                    return true;
                }
            }
        }

        return false;

    }
}
