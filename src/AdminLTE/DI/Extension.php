<?php declare(strict_types=1);

namespace Chap\AdminLTE\DI;

use Chap\AdminLTE\IAdminControlFactory;
use Chap\AdminLTE\Login\ILoginFormFactory;
use Chap\AdminLTE\Menu\IMenuControlFactory;
use Nette;

class Extension extends Nette\DI\CompilerExtension
{
    /**
     * @return array
     */
	private function getDefaultConfig(): array
	{
		$dir = __DIR__ . '/../assets';
		return [
			'wwwDir' => '%wwwDir%',
			'appRoot' => '%wwwDir%/../',
			'menu' => [],
			'skin' => 'blue',
			'footer' => '<strong>Copyright &copy; 2018 <a href="http://www.chap.cz">Jan Loufek</a></strong>',
			'version' => '1.0.0',
			'profileImage' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAC91BMVEUAAAB/xMSAwcGCwsKFw8Noz9ds2Nht1dVx0NBx0tJy0dF1z894zMx5ycl9yMh+xMR/wsKAwMBV0+Nu0tJ+xMRhzdtj0d9u09Ry0NB4zMxVyd9hzdZh0Npny9hr1NR+xcVfzddgwtRay9le0t5VyeBayNNa0Nlm0Npr09dUyNlazth1zc13zMxN0OFRyt1U091d1OJQyt1o0thCvtdIyORy0NBTxtpUydhczdtBwd9RyNhm2tx1zc1g2+FVz+Jf0d1Iw91Rx9xSzN9Z1eQkuOVG0O1OxttOyNxPx9tHwt5Jw9tLxNwostpEwtpKxd5Oyd9h3OBH0/NN1u8/wd5DxeA8u9lAwd5CwNxDw95Ewt07tNE/wttAwN5Cw94/v9o+v9s/v9w/wdw6weI8v9w/wd1AvdY6vuE8v9w5vdw8wN8lrtY8vt05vdsssNQ5vtszv+EnuOE3vNw3vd42vNw4vds1utozutw1vNs2vt02vNwyu9s0uts2tNMjrtY0u9wxuNo4ttMxu90zutw0utw1u90xudsrsNUvudwzutozutwxutszvd8qtNsvudw2vdswudsxu+Eut9oxvd8zt9kxutwtt9svudwuuNwys9QstNgxu9ozuNclstswu9wwttstt9wrttsst9wostgrt9wptNorttwuudorttouutwiteEkt+Esut4otNsptdsqttwntNoptdontNsotdwps9kptNoqtNkotNomtdsptdsksdontdootdsptdoltd0mtNsntNsls9oks9smtNsntdskstontNsls9oks9oltd0jstoltNshstwls9sjstokstoisdogsdshsdojstsesNsfsNogsNogsdofrtggsNohsNkbrdkesNkhsdkrtdgcrtkcr9ocr9sdr9odr9ser9ogr9gbrtobrtscrtkhsdomtdwardkartkbrtkcrtofsNofsdkgsNkot9wpt9sYrNgYrNkZrNkZrdkZrdoardkardoartobrtkbr9qvHauRAAAA83RSTlMAAgICAgQEBAQEBAQEBAQEBAQGBgYICAgICAoKCgoKCgwMEhIUFBQUFBYWFhYYGBgYGhocHBweHh4gICAgIigqLCwuLjAwMDAwNDQ0ODo6PDw+PkRESEhISEhKTExMTlJSUlRWVlpeXmBgYmJmampucHBwdHR2eHh4enx8fIGBg4OFhYWHiYuLi4uPj5GRkZOTlZWVl5mZnZ2hoaGjo6Wpra2zs7e3t729v7+/w8PFx8fJycnJycvR0dPT09PX19fZ29vb3d3f4eHj4+Xl5+fp6+/v8/Pz8/X19ff39/f5+fn5+fn5+/v7+/v9/f39/f39/f0PpQQDAAACZElEQVQYGe3BVVQVURQG4F+xu7u7u7u7xu7u7u7uVuzCbuwWExsVuzuuoI5sLtaDi4frou7M8p45x5f9fWCMMcYYY4wxxhgTUL7v7K3bt+1YPrx+AqiXfdQ5OzncXloRaqUbe5dC8V9bHArVPEvhPOgFZTo+pgjY5yeBGl3fUcTWJIQKrV6QM7OgQKmb5JStM+TzIAM+WSBbUxsZmQnZdpOhe/kgVzUbGRsCuaaTiSOQ6xCZeF4IMqX3JTNNIFPlX2SmH2SqQqbGQKaWZGoZZKpDpqZCpqo/yUx/yJT7EZnpAqkukAlbOUjlTiauQK42gWRsDuRK6U2G3taGZAPI0CbIltaLDLysBemavSfnZkCBSeTU3mRQIPpqcuJkXiiRaEUAReRwESgSY8QzCidwfVaoU9fTTqFd7x4HKiXutM+P/rJ7D8sE1aLUGLrx0v2vX95cPTitcQr8J3lKly0aH0rlKBkVzhUuEAkSuVWf4Pnwt0cxOJF64qsPXksaJYcccVvv9KdgtwZlQARitT1FwewXB6aCBBW2BJHD5cE5EUaadnu+k8P5DrBa5N6+FNKddd0KxoND5uYLblBIn9wzwlLRFv2gsD6f2bBwfJ+eo+euOv6EwtmfHxaKvTKA/tWxXLDOZHLBgaSwSns/csViWCSbD7nErwWsMY9cdDomrFDiNbmqB6wwhVx2AhZwu0YuC6oEcfVIwDiIG0kCdkHcZhLwEeKOkogyEPaURDSAsG8koiGE6SRCgzCdRGgQppMIDcJ0EqFBmE4iNAjTSYQGYTqJ0CBMJxEaGGOMMcYYY4wxxkz8Abjl+JrI6Ox0AAAAAE lFTkSuQmCC',

			'login' => [
				'pageTitle' => 'Login - Admin',
    			'usernameType' => 'email',
			],
            'cssFiles' => [
                'mode' => 'remoteFA',
                'localFA' => [
                    "$dir/full-admin.css",
                    "$dir/styles/font-awesome.min.css",
                ],
                'remoteFA' => [
                    "$dir/full-admin.css",
                    'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                ],
                'custom' => []
            ],
            'jsFiles' => [
                'mode' => 'default',
                'default' => [
                    "$dir/full-admin.js",
                    "$dir/modal.js",
                ],
                'custom' => []
            ],
		];
	}

	public function loadConfiguration(): void
	{
		$config = $this->getConfig($this->getDefaultConfig());
		$builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('baseAdminControl'))
            ->setImplement(IAdminControlFactory::class)
            ->addSetup('configure', [$config]);

        $builder->addDefinition($this->prefix('loginFormControl'))
            ->setImplement(ILoginFormFactory::class)
            ->addSetup('configure', [$config['login']]);

        $builder->addDefinition($this->prefix('menuControl'))
            ->setImplement(IMenuControlFactory::class);
	}
}
