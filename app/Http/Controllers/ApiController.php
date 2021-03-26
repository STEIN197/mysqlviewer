<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locale;
use App\Entity\Column;
use App\Entity\Schema;

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

	public function setLocale(string $locale) {
		session()->put('locale', $locale);
		app()->setLocale($locale);
		return response()->json(session()->all());
	}
}
