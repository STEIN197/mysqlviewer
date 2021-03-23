<?php
namespace App\View;

use App\Entity\Schema;
use App\Util;

class SchemaView extends EntityView {
	
	public function indexActions(): array {
		return [
			'create', 'read', 'update', 'delete', 'truncate'
		];
	}

	public function indexColumns(): array {
		return [
			'SCHEMA_NAME' => [],
			'DEFAULT_CHARACTER_SET_NAME' => [],
			'DEFAULT_COLLATION_NAME' => []
		];
	}

	public function readActions(): array {
		return [
			'create', 'read', 'update', 'delete', 'truncate'
		];
	}

	public function editableProperties(): array {
		return [
			'SCHEMA_NAME' => [
				'readonly' => true,
				'required' => true
			],
			'DEFAULT_COLLATION_NAME' => [
				'type' => 'select',
				'options' => Schema::collations()
			],
			'DEFAULT_CHARACTER_SET_NAME' => [
				'type' => 'select',
				'options' => Schema::charsets()
			]
		];
	}

	protected function renderActionRead(): string {
		$actions = [
			'read', 'update', 'delete', 'truncate'
		];
		ob_start();
		?>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<th><?= __('entity.column.actions') ?></th>
					<th><?= __('entity.type.schema.column.TABLE_NAME') ?></th>
					<th><?= __('entity.type.schema.column.TABLE_ROWS') ?></th>
					<th><?= __('entity.type.schema.column.ENGINE') ?></th>
					<th><?= __('entity.type.schema.column.TABLE_COLLATION') ?></th>
					<th><?= __('entity.type.schema.column.DATA_LENGTH') ?></th>
				</tr>
			</thead>
			<tbody>
				<? foreach ($this->entity->tables() as $table): ?>
					<tr>
						<td><?= join(
							' | ',
							array_map(
								function ($action) use ($table): string {
									return '<a href="'.route($action, ['type' => 'table', 'id' => $table->id(), 'schema' => $this->entity->id()]).'">'.__("entity.action.{$action}").'</a>';
								},
								$actions
							)
						) ?></td>
						<td><?= $table->id() ?></td>
						<td><?= $table->TABLE_ROWS ?? 0 ?></td>
						<td><?= $table->ENGINE ?></td>
						<td><?= $table->TABLE_COLLATION ?></td>
						<td><?= Util::formatBytes($table->DATA_LENGTH + $table->INDEX_LENGTH) ?></td>
					</tr>
				<? endforeach ?>
			</tbody>
		</table>
		<a href="<?= route('create', ['type' => 'table', 'schema' => $this->entity->id()]) ?>" class="btn btn-primary btn-sm"><?= __('entity.action.create') ?></a>
		<?
		return ob_get_clean();
	}
}
