<?php

namespace bx\pimple;

/**
 * Обертка для pimple для битрикса. Реализует singleton для вызова контейнера.
 */
class Container
{
	/**
	 * @var ServiceLocator Объект для singleton шаблона
	 */
	public static $c = null;


	private function __construct()
	{
	}
	
	private function __clone()
	{
	}
	
	private function __wakeup()
	{
	}


	/**
	 * Задает объект pimple, если его требуется кастомизировать
	 * @param \Pimple\Container $pimple
	 */
	public static function set(\Pimple\Container $pimple)
	{
		static::$c = $pimple;
	}
}


$container = new \Pimple\Container;
$container->register(new BitrixProvider);
Container::set($container);