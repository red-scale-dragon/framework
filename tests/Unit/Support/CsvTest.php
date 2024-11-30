<?php

namespace Dragon\Tests\Unit\Support;

use Tests\TestCase;
use Dragon\Support\Csv;

class CsvTest extends TestCase {
	public function testWillParseCsvFile() {
		$csv = new Csv(realpath(__DIR__ . '/../../fixtures/csvtest.csv'));
		
		$this->assertSame([
			"Column 1", "Column 2",
		], $csv->headers);
		
		$this->assertCount(2, $csv->rows);
		$this->assertSame(["Value 1", "Value 2"], $csv->rows[0]);
		$this->assertTrue($csv->isCsv());
	}
}
