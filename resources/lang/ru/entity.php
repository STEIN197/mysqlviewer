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
			'name' => 'Имя'
		],
		'type' => [
			'variable' => [
				'index' => 'Переменные',
				'column' => [
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
				'index' => 'Пользователи'
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
				'index' => 'Базы данных'
			],
		]
	];
