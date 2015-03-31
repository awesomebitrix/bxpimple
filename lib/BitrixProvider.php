<?php

namespace bx\pimple;

/**
 * Контейнер с зависимостями для битрикса
 */
class BitrixProvider implements \Pimple\ServiceProviderInterface
{
	public function register(\Pimple\Container $pimple)
	{
		//объект с приложением битрикса $APPLICATION
		$pimple['application'] = function ($c) {
			global $APPLICATION;
    		return $APPLICATION;
		};

		//объект с пользователем битрикса $USER
		$pimple['user'] = function ($c) {
			global $USER;
    		return $USER;
		};

		//объект с базой данных битрикса $DB
		$pimple['db'] = function ($c) {
			global $DB;
    		return $DB;
		};
	}
}