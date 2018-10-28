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

To use this extension, require it in [Composer](https://getcomposer.org/):

```bash
composer require chapcz/chap-adminlte
```

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

        $admin->onSearch[] = function (Form $form) {
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

##TODO:

- Improve menu control and better authorization for nested items
- Modals
- Some extra components from AdminLTE easy to use from app
- More examples
- More configurable
 
 
## Inspiration

- [Kollarovic/Admin](https://github.com/Kollarovic/Admin)
- [gritbox/AdminLTE](https://github.com/gritbox/AdminLTE)