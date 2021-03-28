<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locale;
use App\Entity\Column;
use Illuminate\Support\Facades\DB;
use App\Entity\Schema;
use App\PDOWrapper;

class ApiController extends Controller
{
    public function index(Request $request) {
		if ($request->input('locale') && Locale::exists($request->input('locale')))
			return $this->setLocale($request->input('locale'));
	}

	public function createColumnView(Request $request) {
		ob_start();
		?>
		<tr class="new">
			<td>
				<a href="javascript:void(0)"><?= __('entity.action.delete') ?></a>
			</td>
			<td>
				<input type="text" name="column[<?= $request->index ?>][COLUMN_NAME]"/>
			</td>
			<td>
				<select name="column[<?= $request->index ?>][DATA_TYPE]">
					<? foreach (Column::dataTypes() as $type): ?>
						<option value="<?= $type ?>"><?= $type ?></option>
					<? endforeach ?>
				</select>
			</td>
			<td>
				<input type="text" name="column[<?= $request->index ?>][COLUMN_DEFAULT]"/>
			</td>
			<td>
				<select name="column[<?= $request->index ?>][COLLATION_NAME]">
					<? foreach (Schema::collations() as $collation): ?>
						<option value="<?= $collation ?>"><?= $collation ?></option>
					<? endforeach ?>
				</select>
			</td>
			<td>
				<input type="checkbox" name="column[<?= $request->index ?>][IS_NULLABLE]"/>
			</td>
			<td>
				<input type="radio" name="PRIMARY"/>
			</td>
			<td>
				<input type="checkbox" name="column[<?= $request->index ?>][COLUMN_KEY]"/>
			</td>
			<td>
				<input type="checkbox" name="column[<?= $request->index ?>][EXTRA]"/>
			</td>
		</tr>
		<?
		return ob_get_clean();
	}

	public function sql(Request $request) {
		$pdo = app()->make(PDOWrapper::class)->getPdo();
		try {
			$result = $pdo->query($request->all()['query']);
			$errorInfo = $pdo->errorInfo();
			if ($errorInfo && $errorInfo[2])
				return response()->json([
					'message' => "{$errorInfo[0]}\n{$errorInfo[1]}\n{$errorInfo[2]}"
				]);
			$result = $result->fetchAll(\PDO::FETCH_ASSOC);
			ob_start();
			?>
			<table class="table table-sm table-bordered table-light table-props table-columns" style="white-space:nowrap">
				<thead class="thead-dark">
					<? foreach ($result[0] as $col => $row): ?>
						<th><?= $col ?></th>
					<? endforeach ?>
				</thead>
				<tbody>
					<? foreach ($result as $row): ?>
						<tr>
							<? foreach ($row as $value): ?>
								<td><?= mb_convert_encoding($value, 'UTF-8') ?></td>
							<? endforeach ?>
						</tr>
					<? endforeach ?>
				</tbody>
			</table>
			<?
			return response()->json([
				'data' => ob_get_clean()
			]);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage()
			]);
		}
	}

	public function setLocale(string $locale) {
		session()->put('locale', $locale);
		app()->setLocale($locale);
		return response()->json(session()->all());
	}
}
