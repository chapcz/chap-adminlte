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
     * @var array<string, mixed>
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
        'id'          => null,
        'isDropdown'  => true,
        'allTitle'    => 'Show all',
        'headerTitle' => 'You have %d notifications.',
        'iconTitle'   => null,
        'classType'   => '',
    ];

    /**
     * @var array<string, mixed>
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
     * @param bool $isDropdown
     * @return static
     */
    protected function setIsDropdown(bool $isDropdown): self
    {
        $this->parameters['isDropdown'] = $isDropdown;

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
     * @param string $title
     * @return static
     */
    public function setIconTitle(?string $title): self
    {
        $this->parameters['iconTitle'] = $title;

        return $this;
    }


    /**
     * @param string $id
     * @return static
     */
    public function setId(?string $id): self
    {
        $this->parameters['id'] = $id;

        return $this;
    }

    /**
     * @param Html<string, mixed> $html
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
        $this->parameters['counter']['minSuccess'] = $minSuccess ?? self::$defaults['counter']['minSuccess'];
        $this->parameters['counter']['minWarning'] = $minWarning ?? self::$defaults['counter']['minWarning'];
        $this->parameters['counter']['minDanger'] = $minDanger ?? self::$defaults['counter']['minDanger'];

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
