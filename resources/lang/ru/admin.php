<?php
	return [
		'overview' => 'Обзор',
		'variables' => 'Переменные',
		'engines' => 'Типы таблиц',
		'encodings' => 'Кодировки',
		'schema' => [
			'new' => 'Новая база',
			'columns' => [
				'SCHEMA_NAME' => 'Имя',
				'DEFAULT_CHARACTER_SET_NAME' => 'Кодировка',
				'DEFAULT_COLLATION_NAME' => 'Сравнение'
			]
		],
		'schemas' => [
			'header' => 'Базы данных',
			'tables' => 'Таблицы'
		],
		'table' => [
			'name' => 'Таблица',
			'data' => 'Данные',
			'structure' => 'Структура',
			'add' => 'Добавить строку',
			'truncate' => 'Очистить',
			'delete' => 'Удалить',
			'rows' => 'Строки',
			'type' => 'Тип',
			'collation' => 'Сравнение',
			'size' => 'Размер',
		],
		'add' => 'Добавить',
		'delete' => 'Удалить',
		'edit' => 'Редактировать',
		'submit' => 'Применить',
		'server' => [
			'mysql' => [
				'header' => 'Конфигурация MySQL',
				'version' => 'Версия',
				'user' => 'Вошедший пользователь',
				'charset' => 'Кодировка соединения',
				'collation' => 'Сравнение соединения'
			],
			'apache' => [
				'header' => 'Конфигурация Apache',
				'version' => 'Версия',
				'modules' => 'Загруженные модули'
			],
			'php' => [
				'header' => 'Конфигурация PHP',
				'version' => 'Версия',
				'ext' => 'Загруженные расширения',
			],
		],
		'users' => [
			'header' => 'Пользователи',
			'name' => 'Имя пользователя',
			'host' => 'Имя хоста',
			'edit' => 'Редактировать',
			'delete' => 'Удалить пользователя'
		],
		'user' => [
			'login' => 'Логин',
			'limits' => 'Ограничения',
			'privileges' => 'Привилегии',
			'submit' => 'Применить',
			'success' => 'Данные успешно сохранены',
			'new' => 'Новый пользователь',
			'columns' => [
				'Host' => 'Хост',
				'User' => 'Логин',
				'Password' => 'Пароль',

				'Select_priv' => 'SELECT',
				'Insert_priv' => 'INSERT',
				'Update_priv' => 'UPDATE',
				'Delete_priv' => 'DELETE',
				'Create_priv' => 'CREATE',
				'Drop_priv' => 'DROP',
				'Reload_priv' => 'RELOAD',
				'Shutdown_priv' => 'SHUTDOWN',
				'Process_priv' => 'PROCESS',
				'File_priv' => 'FILE',
				'Grant_priv' => 'GRANT',
				'References_priv' => 'REFERENCES',
				'Index_priv' => 'INDEX',
				'Alter_priv' => 'ALTER',
				'Show_db_priv' => 'SHOW_DB',
				'Super_priv' => 'SUPER',
				'Create_tmp_table_priv' => 'CREATE_TMP_TABLE',
				'Lock_tables_priv' => 'LOCK_TABLES',
				'Execute_priv' => 'EXECUTE',
				'Repl_slave_priv' => 'REPL_SLAVE',
				'Repl_client_priv' => 'REPL_CLIENT',
				'Create_view_priv' => 'CREATE_VIEW',
				'Show_view_priv' => 'SHOW_VIEW',
				'Create_routine_priv' => 'CREATE_ROUTINE',
				'Alter_routine_priv' => 'ALTER_ROUTINE',
				'Create_user_priv' => 'CREATE_USER',
				'Event_priv' => 'EVENT',
				'Trigger_priv' => 'TRIGGER',
				'Create_tablespace_priv' => 'CREATE_TABLESPACE',
				'Delete_history_priv' => 'DELETE_HISTORY',

				'max_questions' => 'Max questions',
				'max_updates' => 'Max updates',
				'max_connections' => 'Max connections',
				'max_user_connections' => 'Max user connections',
			]
		]
	];
