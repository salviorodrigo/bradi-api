<?php

declare(strict_types=1);

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoNF;

/** Xml string example
 * <ide>
 *  <cNF>83427844</cNF>
 *  <cUF>11</cUF>
 * </ide>
 * <emit>
 *  <CNPJ>60968903000192</CNPJ>
 * </emit>
 */
describe('CodigoNF', function () {
    describe('::parseXmlString()', function () {
        test('Should be return a Result object with himself when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><cUF>11</cUF><cNF>83427844</cNF></ide>';
            $sut = CodigoNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoNF::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('83427844');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cNF>83427844</cNF>');
        });
    });
});
