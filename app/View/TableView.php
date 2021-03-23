<?php
namespace App\View;

class TableView extends EntityView {

	public function indexColumns(): array {
		return [];
	}

	public function indexActions(): array {
		return [];
	}

	public function editableProperties(): array {
		return [];
	}

	protected function renderActionRead(): string {
		static $actions = [
			'update', 'delete'
		];
		$columns = [];
		foreach ($this->entity->columns() as $column)
			$columns[$column->id()] = $column;
		ob_start();
		?>
		<table class="table table-sm table-bordered table-light table-props">
			<thead class="thead-dark">
				<tr>
					<? if ($this->entity->hasPrimaryKey()): ?>
						<th><?= __('entity.column.actions') ?></th>
					<? endif ?>
					<? foreach ($columns as $column): ?>
						<th><?= $column->id() ?></th>
					<? endforeach ?>
				</tr>
			</thead>
			<tbody>
				<? foreach ($this->entity->rows() as $row): ?>
					<tr>
						<? if ($this->entity->hasPrimaryKey()): ?>
							<td><?= join(
								' | ',
								array_map(
									function ($action) use ($row): string {
										return '<a href="'.route($action, ['type' => 'row', 'id' => $row->id(), 'table' => $this->entity->id(), 'schema' => $this->entity->schema()->id()]).'">'.__("entity.action.{$action}").'</a>';
									},
									$actions
								)
							) ?></td>
						<? endif ?>
						<? foreach ($columns as $column): ?>
							<td><?= $row->{$column->id()} ?></td>
						<? endforeach ?>
					</tr>
				<? endforeach ?>
			</tbody>
		</table>
		<a href="<?= route('create', ['type' => 'row', 'schema' => $this->entity->schema()->id(), 'table' => $this->entity->id()]) ?>" class="btn btn-primary btn-sm"><?= __('entity.action.create') ?></a>
		<?
		return ob_get_clean();
	}
}
