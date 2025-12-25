<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\NumeroNF;

/** Xml string example
 * <ide>
 *  <cUF>11</cUF>
 *  <nNF>0</nNF>
 *  <mod>55</mod>
 * </ide>
 * <emit>
 *  <CNPJ>60968903000192</CNPJ>
 * </emit>
 */
describe('NumeroNF', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><nNF>1</nNF></ide>';
            $sut = NumeroNF::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NumeroNF::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('1');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<nNF>1</nNF>');
        });

        test('Should be fail if an invalid nNF value is provided', function () {
            $sut = NumeroNF::parseXmlString('<ide><nNF>0</nNF></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid nNF value is provided', function () {
            $fakeSerie = '1';
            $sut = NumeroNF::create(tagValue: $fakeSerie);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(NumeroNF::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('1');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<nNF>1</nNF>');
        });

        test('Should be fail if an invalid nNF value is provided', function () {
            $sut = NumeroNF::create('0');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
