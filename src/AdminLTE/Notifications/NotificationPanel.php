<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

use Nette\Utils\Html;

class NotificationPanel extends BasePanel
{
    public function __construct()
    {
        parent::__construct();

        $this->setIcon('bell-o')
            ->setClassType('notifications');
    }

    /**
     * @param null|string $link
     * @param string      $text
     * @param string      $icon
     * @param string      $iconColor
     * @return NotificationPanel
     */
    public function addNotification(
        ?string $link, string $text, string $icon = 'check-circle', string $iconColor = 'green'
    ): self {
        $html = Html::el($link === null ? 'span' : 'a', $link === null ? null : ['href' => $link])
            ->addHtml(
                Html::el()->setHtml(
                    sprintf('<i class="fa fa-%s text-%s"></i> %s ', $icon, $iconColor, $this->translator->translate($text))
                )
            );

        return $this->addItem($html);
    }

    /*
     * Example:
     *
     * <a href="#">
     *      <i class="fa fa-users text-aqua"></i> 5 new members joined today
     *  </a>
     *
     */
}
