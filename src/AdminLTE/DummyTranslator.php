<?php declare(strict_types=1);

namespace Chap\AdminLTE;

use Nette\Application\UI\ITemplate;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Localization\ITranslator;

class DummyTranslator implements ITranslator
{
    /**
     * @param       $message
     * @param mixed ...$parameters
     * @return string
     */
    function translate($message, ...$parameters): string
    {
        return $message;
    }

    /**
     * @param Template|ITemplate $template
     * @return Template
     */
    public static function initEmpty(ITemplate $template): Template
    {
        if (! $template instanceof Template) {
            throw new InvalidArgumentException('Dummy translator can be used only for Latte templates');
        }

        try {
            $template->getLatte()->invokeFilter('translate', ['test']);
        } catch (InvalidStateException $e) {
            $template->setTranslator(new self());
        }

        return $template;
    }
}
