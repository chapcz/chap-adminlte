<?php declare(strict_types=1);

namespace Chap\AdminLTE;

interface IAdminControlFactory
{
    /**
     * @return AdminControl
     */
    public function create(): AdminControl;
}
