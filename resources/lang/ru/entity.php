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
					'Host' => 'Хост',
					'Password' => 'Пароль',
					'Alter_priv' => 'ALTER',
					'Alter_routine_priv' => 'ALTER ROUTINE',
					'Create_priv' => 'CREATE',
					'Create_routine_priv' => 'CREATE ROUTINE',
					'Create_tablespace_priv' => 'CREATE TABLESPACE',
					'Create_tmp_table_priv' => 'CREATE TEMPORARY TABLES',
					'Create_user_priv' => 'CREATE USER',
					'Create_view_priv' => 'CREATE VIEW',
					'Delete_priv' => 'DELETE',
					'Drop_priv' => 'DROP',
					'Event_priv' => 'EVENT',
					'Execute_priv' => 'EXECUTE',
					'File_priv' => 'FILE',
					'Grant_priv' => 'GRANT OPTION',
					'Index_priv' => 'INDEX',
					'Insert_priv' => 'INSERT',
					'Lock_tables_priv' => 'LOCK TABLES',
					'Process_priv' => 'PROCESS',
					'References_priv' => 'REFERENCES',
					'Reload_priv' => 'RELOAD',
					'Repl_client_priv' => 'REPLICATION CLIENT',
					'Repl_slave_priv' => 'REPLICATION SLAVE',
					'Select_priv' => 'SELECT',
					'Show_db_priv' => 'SHOW DATABASES',
					'Show_view_priv' => 'SHOW VIEW',
					'Shutdown_priv' => 'SHUTDOWN',
					'Super_priv' => 'SUPER',
					'Trigger_priv' => 'TRIGGER',
					'Update_priv' => 'UPDATE',
					'max_questions' => 'MAX_QUERIES_PER_HOUR',
					'max_updates' => 'MAX_UPDATES_PER_HOUR',
					'max_connections' => 'MAX_CONNECTIONS_PER_HOUR',
					'max_user_connections' => 'MAX_USER_CONNECTIONS',
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
				'action' => [
					'create' => 'Нова база данных'
				],
				'column' => [
					'SCHEMA_NAME' => 'Название',
					'DEFAULT_CHARACTER_SET_NAME' => 'Кодировка',
					'DEFAULT_COLLATION_NAME' => 'Сравнение'
				]
			],
		]
	];
