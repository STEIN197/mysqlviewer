<?php
namespace App\View;

use App\Entity\Engine;
use App\Entity\Schema;

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

	protected function renderActionCreate(): string {
		return $this->renderEdit();
	}

	protected function renderActionUpdate(): string {
		return $this->renderEdit();
	}

	protected function renderEdit(): string {
		ob_start();
		?>
		<input type="hidden" name="schema" value="<?= request()->schema ?>"/>
		<table class="table table-sm table-bordered table-light table-props">
			<tbody>
				<tr>
					<td><?= __('entity.type.table.column.TABLE_NAME') ?></td>
					<td>
						<input type="text" name="TABLE_NAME" required="" value="<?= $this->entity ? $this->entity->id() : '' ?>"/>
					</td>
				</tr>
				<tr>
					<td><?= __('entity.type.table.column.ENGINE') ?></td>
					<th>
						<select name="ENGINE" required="">
							<? foreach (Engine::list() as $engine): ?>
								<option value="<?= $engine->id() ?>" <?= $this->entity && $this->entity->ENGINE === $engine->id() ? 'selected=""' : '' ?> ><?= $engine->id() ?></option>
							<? endforeach ?>
						</select>
					</th>
				</tr>
				<tr>
					<td><?= __('entity.type.table.column.TABLE_COLLATION') ?></td>
					<th>
						<select name="TABLE_COLLATION" required="">
							<? foreach (Schema::collations() as $collation): ?>
								<option value="<?= $collation ?>" <?= $this->entity && $this->entity->TABLE_COLLATION === $collation ? 'selected=""' : '' ?> ><?= $collation ?></option>
							<? endforeach ?>
						</select>
					</th>
				</tr>
			</tbody>
		</table>
		<?
		return ob_get_clean();
	}
}
