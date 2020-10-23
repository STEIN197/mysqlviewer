<?php
	return [
		'overview' => 'Overview',
		'users' => 'Users',
		'variables' => 'Variables',
		'engines' => 'Engines',
		'encodings' => 'Encodings',
		'schemas' => 'Schemas',
		'sql' => 'SQL',
		'server' => [
			'mysql' => [
				'header' => 'MySQL configuration',
				'version' => 'Version',
				'user' => 'Logged user',
				'charset' => 'Connection charset',
				'collation' => 'Connection collation'
			],
			'apache' => [
				'header' => 'Apache configuration',
				'version' => 'Version',
				'modules' => 'Loaded modules'
			],
			'php' => [
				'header' => 'PHP configuration',
				'version' => 'Version',
				'ext' => 'Loaded extensions',
				// TODO: https://www.php.net/manual/ru/function.get-loaded-extensions.php
			]
		]
	];