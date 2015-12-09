<?php

namespace bxpimple;

/**
 * Обертка для pimple для битрикса. Реализует singleton для вызова контейнера.
 */
class Locator
{
	/**
	 * @var ServiceLocator Объект для singleton шаблона
	 */
	public static $item = null;
	/**
	 * @var \Pimple\Container
	 */
	protected $_IoC = null;



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
	 * Возращает объект приложения
	 * @return \bxpimple\ApplicationContainer
	 */
	public static function init(\Pimple\Container $pimple)
	{
		self::$item = new self;
		self::$item->setIoC($pimple);
	}



	/**
	 * Возвращает инициированный объект
	 * @param string $name
	 * @return mixed
	 */
	public function get($name)
	{
		$ioc = $this->getIoC();
		return $ioc[$name];
	}

	/**
	 * Задает фабрику для создания объектов
	 * @param string $name
	 * @param callable $constructor
	 */
	public function registerFactory($name, $constructor)
	{
		$ioc = $this->getIoC();
		$ioc[$name] = $constructor;
	}


	/**
	 * Задает несколько фабрик из массива
	 * @param array $factories
	 */
	public function registerFactories(array $factories)
	{
		foreach ($factories as $name => $constructor) {
			$this->registerFactory($name, $constructor);
		}
	}


	/**
	 * Задает сервис для pimple
	 * @param string $name
	 * @param array $description
	 */
	public function registerService($name, array $description)
	{
		if (empty($description['class'])) return false;

		$ioc = $this->getIoC();
		$ioc[$name] = function ($c) use ($description) {
			$class = $description['class'];
			$configItem = $description;
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
			return $item;
		};

		return true;
	}


	/**
	 * Задает сервисы для pimple через массив
	 * @param array $services
	 */
	public function registerServices(array $services)
	{
		foreach ($services as $name => $description) {
			$this->registerService($name, $description);
		}
	}


	/**
	 * Задает объект pimple
	 * @param \Pimple\Container $pimple
	 */
	public function setIoC(\Pimple\Container $pimple)
	{
		$this->_IoC = $pimple;
	}


	/**
	 * Возвращаеть объект pimple
	 * @return \Pimple\Container
	 */
	public function getIoC()
	{
		return $this->_IoC;
	}
}



$container = new \Pimple\Container;
$container->register(new BitrixProvider);

Locator::init($container);