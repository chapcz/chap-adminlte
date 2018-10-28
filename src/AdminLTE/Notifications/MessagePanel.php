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
        $html = Html::el($link === null ? 'span' : 'a', $link === null ? null : ['href' => $link]);
        if ($userImage !== null) {
            $html = $html->addHtml(
                Html::el('div', ['class' => 'pull-left'])
                    ->addHtml(Html::el('img', ['src' => $userImage, 'class' => 'img-circle']))
            );
        }
        $clock = $timeText === null ? '' : sprintf('<small><i class="fa fa-clock-o"></i> %s</small>', $timeText);
        $html = $html->addHtml(
            Html::el('h4')->setHtml($title . $clock)
        )->addHtml(
            Html::el('p')->setText($text)
        )

        ;

        return $this->addItem($html);
    }
    /*
     * Example:
     *   <a href="#">
     *   	<div class="pull-left">
     *   		<img src="/image/avatar.jpg" class="img-circle" />
     *   	</div>
     *   	<h4>
     *   		Support Team
     *   		<small><i class="fa fa-clock-o"></i> 5 mins</small>
     *   	</h4>
     *   	<p>Why not buy a new awesome theme?</p>
     *   </a>
     */
}
