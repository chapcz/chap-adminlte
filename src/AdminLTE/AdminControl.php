<?php declare(strict_types=1);

namespace Chap\AdminLTE;

use Chap\AdminLTE\Components\ActionButtons\Button;
use Chap\AdminLTE\Components\ActionButtons\DropLink;
use Chap\AdminLTE\Login\ILoginFormFactory;
use Chap\AdminLTE\Login\LoginForm;
use Chap\AdminLTE\Menu\IMenuControlFactory;
use Chap\AdminLTE\Menu\MenuControl;
use Chap\AdminLTE\Notifications\Container;
use Chap\AdminLTE\Notifications\IPanel;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Http\Request;
use Nette\Security\User;
use Nette\Utils\Html;
use WebLoader\Engine;

class AdminControl extends Control
{
    /**
     * @var ILoginFormFactory
     */
    private $loginFormFactory;

    /**
     * @var array<string, mixed>
     */
    private $defaults = [];

    /**
     * @var User
     */
    private $user;

    /**
     * @phpstan-var (callable(Form): void)[]
     * @var callable[]
     */
    public $onSearch = [];

    /**
     * @var IMenuControlFactory
     */
    private $menuControlFactory;

    /**
     * @var Engine
     */
    private $webLoader;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param ILoginFormFactory   $loginFormFactory
     * @param User                $user
     * @param IMenuControlFactory $menuControlFactory
     * @param Request             $request
     * @param Engine              $webLoader
     */
    public function __construct(
        ILoginFormFactory $loginFormFactory,
        User $user,
        IMenuControlFactory $menuControlFactory,
        Request $request,
        Engine $webLoader
    ) {
        $this->loginFormFactory = $loginFormFactory;
        $this->user = $user;
        $this->request = $request;
        $this->menuControlFactory = $menuControlFactory;
        $this->webLoader = $webLoader;
    }

    /**
     * @param array<string, mixed> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->defaults = $configuration;
    }

    /**
     * @return MenuControl
     */
    protected function createComponentMenu(): MenuControl
    {
        return $this->menuControlFactory->create($this->defaults['menu'], $this);
    }

    /**
     * @return Form
     */
    protected function createComponentSearch(): Form
    {
        $form = new Form();
        $form->addText('q');
        $form->addSubmit('submit')
            ->getControlPrototype()->setName('button')
            ->setHtml(Html::el('i')->addAttributes(['class' => 'fa fa-search']));
        $form->onSubmit[] = function(Form $form): void {
        	$this->onSearch($form);
        };

        return $form;
    }

    /**
     * @return Container
     */
    protected function createComponentNotifications(): Container
    {
        return new Container();
    }

    public function addPanel(IPanel $panel): self
    {
        if ($this['notifications'] instanceof Container) {
            $this['notifications']->addPanel($panel);
        }

        return $this;
    }

    /**
     * @param Button $button
     * @return $this
     */
    public function addActionButton(Button $button): self
    {
        $this['menu']['actionButtons']->addButton($button);

        return $this;
    }

    /**
     * @param DropLink $dropLink
     * @return $this
     */
    public function addDropdownLink(DropLink $dropLink): self
    {
        $this['menu']['actionButtons']->addDropdownLink($dropLink);

        return $this;
    }

    /**
     * @return LoginForm
     */
    protected function createComponentLoginForm(): LoginForm
    {
        return $this->loginFormFactory->create();
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->defaults['title'] = $title;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->defaults['profileName'] = $username;
    }

    /**
     * @param string   $content
     * @param object[] $flashes
     */
    public function render(string $content, array $flashes = []): void
    {
        $presenter = $this->getPresenter();
        $template = $presenter !== null && $presenter->getParameter('lte_no_layout') ? 'modal.latte' : 'layout.latte';
        $cssFiles = $this->defaults['cssFiles'];
        $this->webLoader->createCssFilesCollection('admin-bundle')
            ->setFiles(array_merge($cssFiles[$cssFiles['mode']], $cssFiles['custom']));
        $jsFiles = $this->defaults['jsFiles'];
        $this->webLoader->createJsFilesCollection('admin-bundle')
            ->setFiles(array_merge($jsFiles[$jsFiles['mode']], $jsFiles['custom']));

        DummyTranslator::initEmpty($this->createTemplate())
            ->render(
                __DIR__ . '/templates/' . $template,
                array_merge([
                    'content' => $content,
                    'collapsedMenu' => (bool) ($this->request->getCookie('sidebar-toggle-collapsed') ?? false),
                    'flashes' => $flashes,
                    'webLoader' => $this->webLoader->getFilesCollectionRender(),
                ], $this->defaults)
            );
    }

    /**
     * @throws \Nette\Application\AbortException
     */
    public function handleLogout(): void
    {
        $this->user->logout();
        $this->redirect('this');
    }
}
