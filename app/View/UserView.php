<?php
namespace App\View;

class UserView extends EntityView {

	public function indexColumns(): array {
		return [
			'User' => [],
			'Host' => [],
		];
	}

	public function indexActions(): array {
		return [
			'delete', 'update', 'create'
		];
	}

	public function editableProperties(): array {
		return [
			'Host' => [],
			'User' => [],
			'Password' => [
				'type' => 'password',
				'reset' => true
			],
			'Alter_priv' => [
				'type' => 'checkbox'
			],
			'Alter_routine_priv' => [
				'type' => 'checkbox'
			],
			'Create_priv' => [
				'type' => 'checkbox'
			],
			'Create_routine_priv' => [
				'type' => 'checkbox'
			],
			'Create_tablespace_priv' => [
				'type' => 'checkbox'
			],
			'Create_tmp_table_priv' => [
				'type' => 'checkbox'
			],
			'Create_user_priv' => [
				'type' => 'checkbox'
			],
			'Create_view_priv' => [
				'type' => 'checkbox'
			],
			'Delete_priv' => [
				'type' => 'checkbox'
			],
			'Drop_priv' => [
				'type' => 'checkbox'
			],
			'Event_priv' => [
				'type' => 'checkbox'
			],
			'Execute_priv' => [
				'type' => 'checkbox'
			],
			'File_priv' => [
				'type' => 'checkbox'
			],
			'Grant_priv' => [
				'type' => 'checkbox'
			],
			'Index_priv' => [
				'type' => 'checkbox'
			],
			'Insert_priv' => [
				'type' => 'checkbox'
			],
			'Lock_tables_priv' => [
				'type' => 'checkbox'
			],
			'Process_priv' => [
				'type' => 'checkbox'
			],
			'References_priv' => [
				'type' => 'checkbox'
			],
			'Reload_priv' => [
				'type' => 'checkbox'
			],
			'Repl_client_priv' => [
				'type' => 'checkbox'
			],
			'Repl_slave_priv' => [
				'type' => 'checkbox'
			],
			'Select_priv' => [
				'type' => 'checkbox'
			],
			'Show_db_priv' => [
				'type' => 'checkbox'
			],
			'Show_view_priv' => [
				'type' => 'checkbox'
			],
			'Shutdown_priv' => [
				'type' => 'checkbox'
			],
			'Super_priv' => [
				'type' => 'checkbox'
			],
			'Trigger_priv' => [
				'type' => 'checkbox'
			],
			'Update_priv' => [
				'type' => 'checkbox'
			],
			'max_questions' => [
				'type' => 'number'
			],
			'max_updates' => [
				'type' => 'number'
			],
			'max_connections' => [
				'type' => 'number'
			],
			'max_user_connections' => [
				'type' => 'number'
			],
		];
	}
}
