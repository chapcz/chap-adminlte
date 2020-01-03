<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

use Nette\Utils\Html;

class MessagePanel extends BasePanel
{
    public function __construct()
    {
        parent::__construct();

        $this->setIcon('envelope-o')
            ->setClassType('messages');
    }

    /**
     * @param null|string $link
     * @param string      $title
     * @param string      $text
     * @param null|string $userImage
     * @param null|string $timeText
     * @return MessagePanel
     */
    public function addMessage(
        ?string $link, string $title, string $text, ?string $userImage = null, ?string $timeText
    ): self {
        $html = Html::el(
            $link === null ? 'span' : 'a',
            $link === null ? ['class' => 'dropdown-item'] : ['class' => 'dropdown-item', 'href' => $link]
        );
        $mediaDiv = Html::el('div', ['class'=>'media']);
        $html->addHtml($mediaDiv);
        if ($userImage !== null) {
            $mediaDiv->addHtml(Html::el('img', ['src' => $userImage, 'class' => 'img-size-50 mr-3 img-circle']));
        }
        $body = Html::el('div', ['class'=>'media-body']);
        $mediaDiv->addHtml($body);
        $clock = $timeText === null ? '' : sprintf('<p class="text-sm text-muted"><i class="fa fa-clock-o"></i> %s</p>', $timeText);

        $body->addHtml(Html::el('h3', ['class' => 'dropdown-item-title'])->setHtml($title))
            ->addHtml(Html::el('p', ['class' => 'text-sm'])->setText($text))
            ->addHtml($clock ) ;

        return $this->addItem($html);
    }
    /*
     * Example:
     * <a href="#" class="dropdown-item">
     *    <div class="media">
     *        <img src="/docs/3.0/assets/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
     *        <div class="media-body">
     *            <h3 class="dropdown-item-title"> Brad Diesel</h3>
     *            <p class="text-sm">Call me whenever you can...</p>
     *            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
     *        </div>
     *    </div>
     *</a>
     */
 }
