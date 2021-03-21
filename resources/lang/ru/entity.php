<?php
	return [
		'action' => [
			'create' => 'Создать',
			'read' => 'Просмотреть',
			'update' => 'Редактировать',
			'delete' => 'Удалить',
			'submit' => 'Применить',
		],
		'column' => [
			'actions' => 'Действия'
		],
		'type' => [
			'variable' => [
				'index' => 'Переменные',
				'column' => [
					'Variable_name' => 'Имя',
					'Value' => 'Значение'
				]
			],
			'engine' => [
				'index' => 'Типы таблиц',
				'column' => [
					'COMMENT' => 'Комментарий',
					'SUPPORT' => 'Поддержка',
					'TRANSACTIONS' => 'Поддержка транзакций'
				]
			],
			'user' => [
				'index' => 'Пользователи',
				'action' => [
					'create' => 'Новый пользователь'
				],
				'column' => [
					'User' => 'Имя',
					'Host' => 'Хост'
				]
			],
			'encoding' => [
				'index' => 'Кодировки',
				'column' => [
					'COLLATION_NAME' => 'Сравнение',
					'DESCRIPTION' => 'Описание',
					'MAXLEN' => 'Максимальная длина'
				]
			],
			'schema' => [
				'index' => 'Базы данных',
				'column' => [
					'SCHEMA_NAME' => 'Название',
					'DEFAULT_CHARACTER_SET_NAME' => 'Кодировка',
					'DEFAULT_COLLATION_NAME' => 'Сравнение'
				]
			],
		]
	];
