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
				'collation' => 'Connection collation',
				'vars' => [
					'header' => 'MySQL variables',
					'name' => 'Name',
					'value' => 'Value',
				],
				'engines' => [
					'header' => 'MySQL engines',
					'name' => 'Name',
					'support' => 'Support',
					'desc' => 'Description',
					'transactions' => 'Transactions support'
				],
				'encodings' => [
					'header' => 'MySQL character sets',
					'name' => 'Character set name',
					'collations' => 'Collations',
					'defaultCollation' => 'Default collation',
					'maxlen' => 'Max length (in bytes)'
				]
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
			]
			],
			'tables' => 'Tables',
			'functions' => 'Procedures and functions',
			'views' => 'Views',
	];
