<?php

declare(strict_types=1);

/**
 * @internal
 * @coversNothing
 */
class mPDFTest extends PHPUnit_Framework_TestCase
{
    private $mpdf;

    public function setup(): void
    {
        parent::setup();

        $this->mpdf = new mPDF();
    }

    public function testPdfOutput(): void
    {
        $this->mpdf->writeHtml('<html><body>
			<h1>Test</h1>
		</body></html>');

        $output = $this->mpdf->Output(null, 'S');

        $this->assertStringStartsWith('%PDF-', $output);
    }
}
