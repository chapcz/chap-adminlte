<?php declare(strict_types=1);

namespace Chap\AdminLTE;

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
use WebLoader\Compiler;
use WebLoader\FileCollection;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;

class AdminControl extends Control
{
    /**
     * @var ILoginFormFactory
     */
    private $loginFormFactory;

    /**
     * @var array
     */
    private $defaults = [];

    /**
     * @var User
     */
    private $user;

    /**
     * @var callable[]
     */
    public $onSearch = [];

    /**
     * @var IMenuControlFactory
     */
    private $menuControlFactory;

    /**
     * @var string
     */
    private $outputDir = 'webtemp';

    /**
     * @var Request
     */
    private $request;

    /**
     * @param ILoginFormFactory   $loginFormFactory
     * @param User                $user
     * @param IMenuControlFactory $menuControlFactory
     * @param Request             $request
     */
    public function __construct(
        ILoginFormFactory $loginFormFactory,
        User $user,
        IMenuControlFactory $menuControlFactory,
        Request $request
    ) {
        parent::__construct();

        $this->loginFormFactory = $loginFormFactory;
        $this->user = $user;
        $this->request = $request;
        $this->menuControlFactory = $menuControlFactory;
    }

    /**
     * @param array $configuration
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
        $form->onSubmit = $this->onSearch;

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
     * @return LoginForm
     */
    protected function createComponentLoginForm(): LoginForm
    {
        return $this->loginFormFactory->create();
    }

    /**
     * @param string $content
     * @param array  $flashes
     */
    public function render(string $content, array $flashes = []): void
    {
        $template = $this->getPresenter()->getParameter('lte_no_layout') ? 'modal.latte' : 'layout.latte';
        DummyTranslator::initEmpty($this->createTemplate())
            ->render(
                __DIR__ . '/templates/' . $template,
                array_merge(['content' => $content, 'flashes' => $flashes], $this->defaults)
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

    /**
     * @param array $files
     * @return FileCollection
     */
    private function getCollection(array $files): FileCollection
    {
        $fileCollection = new FileCollection($this->defaults['appRoot']);
        $allFiles = array_merge($files[$files['mode']], $files['custom']);
        foreach ($allFiles as $file) {
            if (strpos($file, 'http') === 0 || strpos($file, '//') === 0) {
                $fileCollection->addRemoteFile($file);
            } else {
                $fileCollection->addFile($file);
            }
        }

        return $fileCollection;
    }

    /**
     * @return CssLoader
     */
    public function createComponentCss(): CssLoader
    {
        $compiler = Compiler::createCssCompiler(
            $this->getCollection($this->defaults['cssFiles']),
            $this->defaults['wwwDir'] . '/' . $this->outputDir
        );

        return new CssLoader($compiler, $this->request->url->basePath . $this->outputDir);
    }

    /**
     * @return JavaScriptLoader
     */
    public function createComponentJs(): JavaScriptLoader
    {
        $compiler = Compiler::createCssCompiler(
            $this->getCollection($this->defaults['jsFiles']),
            $this->defaults['wwwDir'] . '/' . $this->outputDir
        );

        return new JavaScriptLoader($compiler, $this->request->url->basePath . $this->outputDir);
    }
}
