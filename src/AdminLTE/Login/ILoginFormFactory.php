<?php declare(strict_types=1);

namespace Chap\AdminLTE\Login;

interface ILoginFormFactory
{
    /**
     * @return LoginForm
     */
    public function create(): LoginForm;
}
