<?php

declare(strict_types=1);

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;

/** Xml string example
 * <ide>
 *  <cUF>11</cUF>
 * </ide>
 */
describe('CodigoUF', function () {
    describe('::parseXmlString()', function () {
        test('Should be return a Result object with himself when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><cUF>11</cUF></ide>';
            $sut = CodigoUF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CodigoUF::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('11');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<cUF>11</cUF>');
        });
    });
});
