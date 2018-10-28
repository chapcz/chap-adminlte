<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

use Nette\Utils\Html;

class TaskPanel extends BasePanel
{
    public function __construct()
    {
        parent::__construct();

        $this->setIcon('flag-o')
            ->setClassType('tasks');
    }

    /**
     * @param null|string $link
     * @param string      $taskName
     * @param int         $percent
     * @param string      $completionText
     * @return TaskPanel
     */
    public function addTask(
        ?string $link, string $taskName, int $percent, string $completionText = '%d%% Complete'
    ): self {
        $html = Html::el($link === null ? 'span' : 'a', $link === null ? null : ['href' => $link])
            ->addHtml(
                Html::el('h3')
                    ->addHtml(sprintf('%s <small class="pull-right">%d%%</small>', $taskName, $percent))
            )
            ->addHtml(
                Html::el('div', ['class' => 'progress xs'])
                    ->addHtml(
                        Html::el('div', [
                            'class'         => 'progress-bar',
                            'style'         => sprintf('width: %d%%', $percent),
                            'role'          => 'progressbar',
                            'aria-valuemax' => '100',
                            'aria-valuemin' => '0',
                            'aria-valuenow' => $percent,
                        ])->addHtml(
                            Html::el('span', ['class' => 'sr-only'])->setText(sprintf($completionText, $percent))
                        )
                    )
            );

        return $this->addItem($html);
    }

    /**
     * Result:
     *
     *  <a href="#">
     *  	<h3>
     *  		Design some buttons
     *  		<small class="pull-right">20%</small>
     *  	</h3>
     *  	<div class="progress xs">
     *  		<div class="progress-bar" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
     *  			<span class="">20% Complete</span>
     *  		</div>
     *  	</div>
     *  </a>
     */
}
