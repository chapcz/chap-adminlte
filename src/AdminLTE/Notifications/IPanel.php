<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

interface IPanel
{
    /**
     * From Nette UI Control
     * @return void
     */
    public function render(): void;
}
