<?php
namespace App\View;

use App\Util;
use App\Entity\Entity;
use App\Entity\Table;

class RowView extends EntityView {
	
	public function indexActions(): array {
		return [];
	}

	public function indexColumns(): array {
		return [];
	}

	protected function renderActionCreate(): string {
		return $this->renderEdit();
	}

	protected function renderActionUpdate(): string {
		return $this->renderEdit();
	}

	private function renderEdit(): string {
		ob_start();
		?>
		<table class="table table-sm table-bordered table-light table-props">
			<tbody>
				<? foreach ($this->table()->columns() as $column): ?>
					<tr>
						<td>
							<b><?= $column->id() ?></b>
						</td>
						<td>
							<?
							$isRequired = $column->COLUMN_KEY !== 'PRI' && strtolower($column->EXTRA) !== 'auto_increment' && !Util::toBool($column->IS_NULLABLE);
							switch (strtolower($column->DATA_TYPE)):
								case 'tinyint':
								case 'smallint':
								case 'mediumint':
								case 'int':
								case 'bigint':
								case 'decimal':
								case 'numeric':
								case 'float':
								case 'double':
								case 'year':
									?>
									<input <?= $isRequired ? 'required=""' : '' ?> type="number" name="<?= $column->id() ?>" value="<?= $this->entity ? htmlentities($this->entity->data()[$column->id()]) : '' ?>"/>
									<?
									break;
								case 'bit':
									?>
									<input <?= $isRequired ? 'required=""' : '' ?> type="checkbox" name="<?= $column->id() ?>" <?= $this->entity && $this->entity->data()[$column->id()] ? 'checked=""' : '' ?>/>
									<?
									break;
								case 'date':
									?>
									<input <?= $isRequired ? 'required=""' : '' ?> type="date" name="<?= $column->id() ?>" value="<?= $this->entity ? htmlentities($this->entity->data()[$column->id()]) : '' ?>"/>
									<?
									break;
								case 'datetime':
								case 'timestamp':
									?>
									<input <?= $isRequired ? 'required=""' : '' ?> type="datetime" name="<?= $column->id() ?>" value="<?= $this->entity ? htmlentities($this->entity->data()[$column->id()]) : '' ?>"/>
									<?
									break;
								case 'time':
									?>
									<input <?= $isRequired ? 'required=""' : '' ?> type="time" name="<?= $column->id() ?>" value="<?= $this->entity ? htmlentities($this->entity->data()[$column->id()]) : '' ?>"/>
									<?
									break;
								case 'tinytext':
								case 'text':
								case 'mediumtext':
								case 'longtext':
									?>
									<textarea rows="5" name="<?= $column->id() ?>"><?= $this->entity ? htmlentities($this->entity->data()[$column->id()]) : '' ?></textarea>
									<?
									break;
								case 'set':
								case 'enum':
									$values = explode(',', preg_replace('/(?:^(?:set|enum)\(|\)$|[\'\"])/', '', $column->COLUMN_TYPE));
									$selectedValues = $this->entity && $this->entity->data()[$column->id()] ? explode(',', $this->entity->data()[$column->id()]) : [];
									?>
									<select name="<?= $column->id().(strtolower($column->DATA_TYPE) === 'set' ? '[]' : '') ?>" <?= strtolower($column->DATA_TYPE) === 'set' ? 'multiple=""' : '' ?>>
										<? foreach ($values as $value): ?>
											<option value="<?= htmlentities($value) ?>" <?= in_array($value, $selectedValues) ? 'selected=""' : '' ?>><?= htmlentities($value) ?></option>
										<? endforeach ?>
									</select>
									<?
									break;
								case 'char':
								case 'varchar':
								default:
									?>
									<input <?= $isRequired ? 'required=""' : '' ?> type="text" name="<?= $column->id() ?>" value="<?= $this->entity ? htmlentities($this->entity->data()[$column->id()]) : '' ?>"/>
									<?
							endswitch
							?>
						</td>
					</tr>
				<? endforeach ?>
			</tbody>
		</table>
		<?
		return ob_get_clean();
	}

	private function table(): Table {
		return Table::read(request()->table, request()->all());
	}

	public static function route(string $action, array $data): string {
		switch (strtolower($action)) {
			case 'index': {
				return route('read', [
					'id' => $data['table'],
					'type' => 'table',
					'schema' => $data['schema']
				]);
			}
		}
	}
}
