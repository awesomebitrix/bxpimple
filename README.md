# Pimple для 1с битрикс

Обертка для подключения [pimple](http://pimple.sensiolabs.org/) для 1с битрикс. Оборачивает pimple в singleton контейнер. Инициирует контейнер со стартовыми параметрами для $APPLICATION, $USER и $DB.

## Установка

Устанавливается с помощью [Composer](https://getcomposer.org/doc/00-intro.md).

Добавьте в ваш composer.json в раздел `require`:

```javascript
"require": {
    "marvin255/bxpimple": "dev-master"
}
```

И в раздел `repositories`:

```javascript
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/marvin255/bxpimple"
    }
]
```

## Использование

Контейнер

```php
\bx\pimple\Container::$c['session_storage'] = function ($c) {
  return new SessionStorage('SESSION_ID');
};
```

$APPLICATION

```php
\bx\pimple\Container::$c['application']->SetTitle('test');
```

$USER

```php
\bx\pimple\Container::$c['user']->GetID();
```

$DB

```php
\bx\pimple\Container::$c['db']->Query('SELECT * FROM b_event');
```
