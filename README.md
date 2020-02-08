# Nette Framework AdminLTE Control


* [AdminLTE](https://github.com/almasaeed2010/AdminLTE)
* [Nette Framework](https://nette.org/)

This extension simplifies the creation of Administration control.

Features:
- Easy install and use
- Included scripts and styles
- Simple use of multiple notification panels
- Translations
- Prepared login control
- PHP 7.2 strict
- PHPStan level 7 
- Configurable as Nette extension
- Menu tree configurable in neon (also user restrictions)


## Usage

* [Sandbox with example integration](https://github.com/chapcz/admin-sandbox)

To use this extension, require it in [Composer](https://getcomposer.org/):

```bash
composer require chapcz/chap-adminlte
```
Minimal setup
```neon
extensions:
	admin: Chap\AdminLTE\DI\Extension

admin:
	
	menu:
		-
			name: "Home"
			link: "Admin:"
			icon: "fa-files-o"
			resource: "home"
			privilege: "view"
		-
			name: "Dvaaa"
			icon: "fa-pie-chart"
			role: "user"
			items:
				-
					name: Boo
					link: "Admin:boo"
					icon: fa-trip
				-
					name: Foo
					link: "Admin:foo"
					icon: fa-trip
					items:
					    -
					        name: Hoo
					        link: "Admin:hoo"
					        icon: fa-trip
```
### Example with panels and search callback  

Presenter 
```php
<?php declare(strict_types=1);

namespace Chap\AdminModule\Presenters;

use Chap\AdminLTE\AdminControl;
use Chap\AdminLTE\IAdminControlFactory;
use Chap\AdminLTE\Notifications\MessagePanel;
use Chap\AdminLTE\Notifications\NotificationPanel;
use Chap\AdminLTE\Notifications\TaskPanel;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

class AdminPresenter extends Presenter
{
    /**
     * @var IAdminControlFactory
     */
    private $adminControlFactory;

    public function __construct(IAdminControlFactory $adminControlFactory)
    {
        parent::__construct();
        $this->adminControlFactory = $adminControlFactory;
    }

    /**
     * @return AdminControl
     */
    protected function createComponentAdmin(): AdminControl
    {
        $admin = $this->adminControlFactory
            ->create()
            ->addPanel($this->getExampleNotificationsPanel())
            ->addPanel($this->getExampleTasksPanel())
            ->addPanel($this->getMessagesPanel());

        $admin->onSearch[] = function (Form $form): void {
            $this->redirect('search', ['word' => $form->getValues()['q']]);
        };

        return $admin;
    }

    private function getExampleNotificationsPanel() :NotificationPanel
    {
        return (new NotificationPanel())
            ->setLinkAll('#')
            ->setCounter(50)
            ->setHeaderTitle('%d Notifications')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ->addNotification('#', 'Something')
            ;
    }

    private function getMessagesPanel() :MessagePanel
    {
        return (new MessagePanel())
            ->setLinkAll('#')
            ->setCounter(2)
            ->setHeaderTitle('%d messages')
            ->addMessage('#', 'Hallo', 'world !', '/image/avatar.png', '2 hours ago')
            ->addMessage('#', 'This', 'is message', '/image/avatar.png', '3 hours ago');
    }

    private function getExampleTasksPanel() :TaskPanel
    {
        $panel = (new TaskPanel())
            ->setLinkAll('#')
            ->setCounter(0)
            ->setHeaderTitle(null);

        for ($i = 1; $i <= 10; $i++ ) {
            $panel->addTask('#', 'My task ' . $i, $i*10);
        }

        return $panel;
    }

    /**
     * @param $word
     */
    public function actionSearch(string $word): void
    {
        $this->flashMessage('Looking for: ' . $word, 'danger');
    }
}
```

@layout.latte 
```latte
{capture $content}{include content}{/capture}

{control admin $content, $flashes}
```
##Modals:
For `a` tags with modal property will be shown "no-layout" result inside modal window.

```latte
<a n:href="edit" class="btn btn-success" modal>Add user</a>
```

## Components:
##### Lazy screen (shown in demo site):

```php

    protected function createComponentSlowScreen(): SlowComponent
    {
        return $this->slowComponentFactory->create();
    }

    // Component with slow response (reading remote data, compute something) 
    protected function createComponentSlowScreenLazyLoaded(): LazyScreen
    {
        return new LazyScreen(function () {
            return $this->slowComponentFactory->create();
        });
    }
```

##### Action buttons (shown in demo site):
Sometimes is useful to add some actions related for view (e.g. on product detail edit, send, assign etc.). 

```php
    public function renderDetail(): void
    {
        $this['admin']->addActionButton(Button::builder()->typeWarning()
            ->link($this->link('this#test'))->faIcon('eye')->build());
        $this['admin']->addActionButton(Button::builder()->typeInfo()
            ->link($this->link('this#test2'))->faIcon('cog')->build());
        $this['admin']->addDropdownLink(new DropLink('', 'link'));
    }
```
##### Info-board (shown in demo site):
For dashboard purposes we can show some info boxes with useful information.

```php
    protected function createComponentDashBoard(): InfoBoard
    {
        return (new InfoBoard())
            ->setColSpan(6)
            ->addBox((new InfoBox())
                ->setColor('red')
                ->setLink('#')
                ->setIcon('pencil')
                ->setNumber(1222)
                ->setProgress(90)
                ->setText('Pencil text')
            )
            ->addBox((new InfoBox())
                ->setColor('green')
                ->setIcon('globe')
                ->setText('Globe text')
                ->setNumber((float) random_int(0, 9999))
            );
    }
```

## TODO:

- Improve menu control and better authorization for nested items
- More examples
 
 
## Inspiration

- [Kollarovic/Admin](https://github.com/Kollarovic/Admin)
- [gritbox/AdminLTE](https://github.com/gritbox/AdminLTE)
