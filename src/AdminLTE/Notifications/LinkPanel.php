<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

class LinkPanel extends BasePanel
{
    public function __construct()
    {
        parent::__construct();

        $this->setIcon('envelope')
            ->setIsDropdown(false);
    }
}
