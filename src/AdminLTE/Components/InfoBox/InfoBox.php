<?php declare(strict_types=1);

namespace Chap\AdminLTE\Components\InfoBox;

use Chap\AdminLTE\DummyTranslator;
use Nette\Application\UI\Control;

class InfoBox extends Control
{
    /** @var string  */
    private $color = 'green';
    /** @var string  */
    private $icon = 'none';
    /** @var string */
    private $text;
    /** @var float */
    private $number;
    /** @var int */
    private $progress;
    /** @var string */
    private $progressText;
    /** @var string */
    private $link;
    /** @var array<string, string> */
    private $linkParams;

    public function render(): void
    {
        DummyTranslator::initEmpty($this->createTemplate())
            ->render(__DIR__ . '/box.latte', ['box' => $this]);
    }

    /**
     * @param string $color
     * @return InfoBox
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param string $icon
     * @return InfoBox
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param string $text
     * @return InfoBox
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param float $number
     * @return InfoBox
     */
    public function setNumber(float $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @param int $progress
     * @return InfoBox
     */
    public function setProgress(int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * @param string $progressText
     * @return InfoBox
     */
    public function setProgressText(string $progressText): self
    {
        $this->progressText = $progressText;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return int|null
     */
    public function getProgress(): ?int
    {
        return $this->progress;
    }

    /**
     * @return string|null
     */
    public function getProgressText(): ?string
    {
        return $this->progressText;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return InfoBox
     */
    public function setLink($link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getLinkParams(): ?array
    {
        return $this->linkParams;
    }

    /**
     * @param mixed $linkParams
     * @return InfoBox
     */
    public function setLinkParams($linkParams): self
    {
        $this->linkParams = $linkParams;

        return $this;
    }
}
