<?php declare(strict_types=1);

namespace Chap\AdminLTE\Login;

use Chap\AdminLTE\DummyTranslator;
use Nette\Application\UI\Control;
use Nette\Forms\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

class LoginForm extends Control
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var array<string, mixed>
     */
    private $defaults = [];

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param array<string, mixed> $defaults
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
        $form = new \Nette\Application\UI\Form();

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
        $form->onSuccess[] = function (Form $form, ArrayHash $values): void {
            $this->process($form, $values);
        };

        return $form;
    }

    /**
     * @param Form                     $form
     * @param ArrayHash<string, mixed> $values
     */
    public function process(Form $form, ArrayHash $values): void
    {
        try {
            if ($values->remember) {
                $this->user->setExpiration('14 days');
            } else {
                $this->user->setExpiration('10 minutes');
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
