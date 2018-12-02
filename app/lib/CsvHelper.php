<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 25-11-2018
 * Time: 0:12
 */

namespace lib;

class CsvHelper
{
	public function arrayToCsv(array $csv = [], $csv_name = 'download'){
		$keys = array_keys($csv[0]);

		ob_end_clean();

		$fp = fopen($csv_name . '.csv', 'w');

		fputcsv($fp, $keys);

		foreach ($csv as $fields) {
		    fputcsv($fp, $fields);
		}

		fclose($fp);

		header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=download.csv');
	}
}