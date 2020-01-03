<?php declare(strict_types=1);

namespace Chap\AdminLTE\Components\InfoBox;

use Chap\AdminLTE\DummyTranslator;
use Nette\Application\UI\Control;

class InfoBoard extends Control
{
    /** @var InfoBox[] */
    private $boxes = [];
    /** @var int  */
    private $colSpan = 4;

    /**
     * @param InfoBox $box
     * @return $this
     */
    public function addBox(InfoBox $box): self
    {
        $this->boxes[] = $box;

        return $this;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    public function setColSpan(int $perPage): self
    {
        if ($perPage >= 12) {
            $this->colSpan = 1;
        } elseif ($perPage >= 6) {
            $this->colSpan = 2;
        } elseif ($perPage >= 4) {
            $this->colSpan = 3;
        } elseif ($perPage >= 3) {
            $this->colSpan = 4;
        } elseif ($perPage >= 2) {
            $this->colSpan = 6;
        } else {
            $this->colSpan = 12;
        }

        return $this;
    }

    public function render(): void
    {
        DummyTranslator::initEmpty($this->createTemplate())
            ->render(__DIR__ . '/board.latte', ['board' => $this]);
    }

    /**
     * @return InfoBox[]
     */
    public function getBoxes(): array
    {
        return $this->boxes;
    }

    /**
     * @return int
     */
    public function getColSpan(): int
    {
        return $this->colSpan;
    }
}
