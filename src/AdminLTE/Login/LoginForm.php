<?php declare(strict_types=1);

namespace Chap\AdminLTE\Login;

use Chap\AdminLTE\DummyTranslator;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

class LoginForm extends Control
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $defaults = [];

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * @param array $defaults
     */
    public function configure(array $defaults): void
    {
        $this->defaults = $defaults;
    }

    /**
     * @return Form
     */
    protected function createComponentForm(): Form
    {
        $form = new Form();

        if ($this->defaults['usernameType'] === 'email') {
            $form->addText('username', 'Email')
                ->setHtmlAttribute('placeholder', 'Email')
                ->setRequired('Please enter your email.')
                ->addRule(Form::EMAIL, 'Please enter a valid email address.');
        } else {
            $form->addText('username', 'Username')
                ->setHtmlAttribute('placeholder', 'Username')
                ->setRequired('Please enter your username.');
        }

        $form->addPassword('password', 'Password')
            ->setHtmlAttribute('placeholder', 'Password')
            ->setRequired('Please enter your password.');

        $form->addCheckbox('remember', 'Remember Me');
        $form->addSubmit('submit', 'Sign In');
        $form->onSuccess[] = [$this, 'process'];

        return $form;
    }

    /**
     * @param Form $form
     */
    public function process(Form $form): void
    {
        $values = $form->values;
        try {
            if ($values->remember) {
                $this->user->setExpiration('14 days', false);
            } else {
                $this->user->setExpiration(0, true);
            }
            $this->user->login($values->username, $values->password);

        } catch (AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    public function render(): void
    {
        DummyTranslator::initEmpty($this->getTemplate())
            ->render(__DIR__ . '/template.latte', $this->defaults);
    }
}
