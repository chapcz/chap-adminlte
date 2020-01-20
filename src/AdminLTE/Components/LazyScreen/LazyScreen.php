<?php declare(strict_types=1);

namespace Chap\AdminLTE\Components\LazyScreen;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\ComponentModel\IComponent;

class LazyScreen extends Control
{
    /**
     * @var bool
     */
    public $loaded = false;

    /**
     * @var callable
     */
    private $factoryCallback;

    /**
     * @param callable $factory
     */
    public function __construct(callable $factory)
    {
        $this->factoryCallback = $factory;
    }

    public function handleLoad(): void
    {
        $this->loaded = true;
        $this->redrawControl('async');
    }

    /**
     * @return IComponent|null
     */
    protected function createComponentAsync(): ?IComponent
    {
        return call_user_func($this->factoryCallback);
    }

    public function render(): void
    {
        /** @var Template $template */
        $template = $this->getTemplate();
        $template->render(__DIR__ . DIRECTORY_SEPARATOR . 'template.latte', ['isLoaded' => $this->loaded]);
    }
}
