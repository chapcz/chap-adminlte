<?php declare(strict_types=1);

namespace Chap\AdminLTE\Components\ActionButtons;

class ButtonBuilder
{
    /** @var string */
    public $link;
    /** @var string|null */
    public $type;
    /** @var string|null */
    public $caption;
    /** @var string|null */
    public $icon;
    /** @var string|null */
    public $title;

    /**
     * @param string $link
     * @return ButtonBuilder
     */
    public function link(string $link): ButtonBuilder
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @param string $type
     * @return ButtonBuilder
     */
    /**
     * @param string|null $type
     * @return ButtonBuilder
     */
    public function type(?string $type): ButtonBuilder
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $caption
     * @return ButtonBuilder
     */
    public function caption(string $caption): ButtonBuilder
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * @param string $icon
     * @return ButtonBuilder
     */
    public function icon(string $icon): ButtonBuilder
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param string|null $icon
     * @return ButtonBuilder
     */
    public function faIcon(?string $icon): ButtonBuilder
    {
        $this->icon = "fa fa-$icon";

        return $this;
    }

    /**
     * @param string|null $title
     * @return ButtonBuilder
     */
    public function title(?string $title): ButtonBuilder
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typePrimary() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_PRIMARY;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typeSecondary() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_SECONDARY;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typeSuccess() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_SUCCESS;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typeDanger() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_DANGER;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typeWarning() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_WARNING;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typeInfo() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_INFO;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typeLight() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_LIGHT;

        return $this;
    }

    /**
     * @return ButtonBuilder
     */
    public function typeDark() : ButtonBuilder
    {
        $this->type = Button::$BUTTON_TYPE_DARK;

        return $this;
    }

    /**
     * @return Button
     */
    public function build(): Button
    {
        return new Button($this->link, $this->type, $this->caption, $this->icon, $this->title);
    }
}
