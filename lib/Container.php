<?php

namespace bxpimple;

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

	/**
	 * Задает сервисы для pimple через массив
	 * @param array $services
	 */
	public static function registerServices(array $services)
	{
		foreach ($services as $name => $config) {

			if (empty($config) || (is_array($config) && empty($config['class']))) continue;

			static::$c[$name] = function ($c) use ($config) {
				$item = null;
				if (is_array($config)) {
					$class = $config['class'];
					$configItem = $config;
					unset($configItem['class']);
					$item = new $class;
					foreach ($configItem as $key => $value) {
						if (property_exists($item, $key)) {
							$item->$key = $value;
						} elseif (method_exists($item, 'set' . ucfirst($key))) {
							$method = 'set' . ucfirst($key);
							$item->$method($value);
						}
					}
				} else {
					$item = new $config;
				}
				return $item;
			};
			
		}
	}
}


$container = new \Pimple\Container;
$container->register(new BitrixProvider);
Container::set($container);