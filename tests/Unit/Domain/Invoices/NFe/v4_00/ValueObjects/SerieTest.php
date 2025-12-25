<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\Serie;

/** Xml string example
 * <ide>
 *  <cUF>11</cUF>
 *  <serie>0</serie>
 *  <mod>55</mod>
 * </ide>
 * <emit>
 *  <CNPJ>60968903000192</CNPJ>
 * </emit>
 */
describe('Mod', function () {
    describe('::parseXmlString()', function () {
        test('Should be succeed when a valid xml string is provided', function () {
            $fakeXmlString = '<ide><serie>0</serie></ide>';
            $sut = Serie::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Serie::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('0');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<serie>0</serie>');
        });

        test('Should be fail if an invalid serie value is provided', function () {
            $sut = Serie::parseXmlString('<ide><serie>970</serie></ide>');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be succeed if a valid serie value is provided', function () {
            $fakeSerie = '0';
            $sut = Serie::create(tagValue: $fakeSerie);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(Serie::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('0');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<serie>0</serie>');
        });

        test('Should be fail if an invalid serie value is provided', function () {
            $sut = Serie::create('970');
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
