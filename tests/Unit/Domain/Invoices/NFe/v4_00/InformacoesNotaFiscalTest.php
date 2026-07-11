<?php

declare(strict_types=1);

describe('InformacoesNotaFiscal', function () {
    describe('::parse()', function () {
        test('Should succeed if InformacoesNotaFiscal is declared', function () {
            expect(class_exists('BradiNfeApi\Domain\Invoices\NFe\v4_00\InformacoesNotaFiscal'))->toBeTrue();
        });
    });
});
