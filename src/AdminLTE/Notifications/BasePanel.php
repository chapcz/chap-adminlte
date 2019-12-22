<?php declare(strict_types=1);

namespace Chap\AdminLTE\Notifications;

use Chap\AdminLTE\DummyTranslator;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;
use Nette\Utils\Html;

abstract class BasePanel extends Control implements IPanel
{
    /**
     * Template parameters
     * @var array
     */
    private static $defaults = [
        'counter'     => [
            'count'      => 0,
            'show'       => true,
            'minSuccess' => 0,
            'minWarning' => 10,
            'minDanger'  => 20,
            'type'       => 'success',
        ],
        'icon'        => 'bell-o',
        'linkAll'     => null,
        'allTitle'    => 'Show all',
        'headerTitle' => 'You have %d notifications.',
        'classType'   => '',
    ];

    /**
     * @var array
     */
    protected $parameters = [
        'items' => [],
    ];

    /**
     * @var ITranslator
     */
    protected $translator;


    public function __construct(ITranslator $translator = null)
    {
        $this->translator = $translator ?? new DummyTranslator();
    }

    /**
     * @param string $icon
     * @return static
     */
    public function setIcon(string $icon): self
    {
        $this->parameters['icon'] = $icon;

        return $this;
    }

    /**
     * @param string $classType
     * @return static
     */
    protected function setClassType(string $classType): self
    {
        $this->parameters['classType'] = $classType;

        return $this;
    }

    /**
     * @param string $link
     * @return static
     */
    public function setLinkAll(string $link): self
    {
        $this->parameters['linkAll'] = $link;

        return $this;
    }

    /**
     * @param string $title
     * @return static
     */
    public function setHeaderTitle(?string $title): self
    {
        $this->parameters['headerTitle'] = $title;

        return $this;
    }

    /**
     * @param Html $html
     * @return static
     */
    protected function addItem(Html $html): self
    {
        $this->parameters['items'][] = $html;

        return $this;
    }

    /**
     * @param int      $count
     * @param int|null $minSuccess
     * @param int|null $minWarning
     * @param int|null $minDanger
     * @return static
     */
    public function setCounter(
        int $count,
        int $minSuccess = null,
        int $minWarning = null,
        int $minDanger = null
    ): self {
        $this->parameters['counter'] = [
            'count' => $count,
        ];
        $minSuccess === null ? null : $this->parameters['counter']['minSuccess'];
        $minWarning === null ? null : $this->parameters['counter']['minWarning'];
        $minDanger === null ? null : $this->parameters['counter']['minDanger'];

        return $this;
    }

    public function render(): void
    {
        $values = array_replace_recursive(self::$defaults, $this->parameters);

        $title = $values['headerTitle'];
        if ($title !== null && strpos($title, '%d') !== false) {
            $values['headerTitle'] = sprintf($title, $values['counter']['count']);
        }
        $count = $values['counter']['count'];
        if ($values['counter']['show'] === true && $values['counter']['count'] > 0) {
            if ($count > $values['counter']['minWarning']) {
                $values['counter']['type'] = 'warning';
            }
            if ($count > $values['counter']['minDanger']) {
                $values['counter']['type'] = 'danger';
            }
        }

        DummyTranslator::initEmpty($this->getTemplate())
            ->render(
            __DIR__ . '/template.latte',
                (array) $values
        );
    }
}
