<?php declare(strict_types=1);

namespace Chap\AdminLTE\Components\ActionButtons;

class Button
{
    /** @var string  */
    public static $BUTTON_TYPE_PRIMARY = 'primary';
    /** @var string  */
    public static $BUTTON_TYPE_SECONDARY = 'secondary';
    /** @var string  */
    public static $BUTTON_TYPE_SUCCESS = 'success';
    /** @var string  */
    public static $BUTTON_TYPE_DANGER = 'danger';
    /** @var string  */
    public static $BUTTON_TYPE_WARNING = 'warning';
    /** @var string  */
    public static $BUTTON_TYPE_INFO = 'info';
    /** @var string  */
    public static $BUTTON_TYPE_LIGHT = 'light';
    /** @var string  */
    public static $BUTTON_TYPE_DARK = 'dark';

    /** @var string */
    public $link;
    /** @var string */
    public $type;
    /** @var string|null */
    public $caption;
    /** @var string|null */
    public $icon;
    /** @var string|null */
    public $title;

    /**
     * @param string      $link
     * @param string      $type
     * @param string|null $caption
     * @param string|null $icon
     * @param string|null $title
     */
    public function __construct(string $link, string $type, ?string $caption = null, ?string $icon = null, ?string $title = null)
    {
        $this->link = $link;
        $this->type = $type;
        $this->caption = $caption;
        $this->icon = $icon;
        $this->title = $title;
    }

    /**
     * @return ButtonBuilder
     */
    public static function builder(): ButtonBuilder
    {
        return new ButtonBuilder();
    }
}
