<?php

declare(strict_types=1);

use BradiNfeApi\Common\Exceptions\ValidationError;
use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CadastroPJ;

/** Xml string example
 * <emit>
 *  <CNPJ>28214544000175</CNPJ>
 * </emit>
 */
describe('CadastroPJ', function () {
    describe('::parseXmlString()', function () {
        test('Should be return a Result object with himself when a valid xml string is provided', function () {
            $fakeXmlString = '<emit><CNPJ>28214544000175</CNPJ></emit>';
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CadastroPJ::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('28214544000175');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('<CNPJ>28214544000175</CNPJ>');
        });

        test('Should be succeed if an empty string is provided', function () {
            $fakeXmlString = '';
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CadastroPJ::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be succeed if null given', function () {
            $fakeXmlString = null;
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CadastroPJ::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be return a failure Result if an object value is provided', function () {
            $fakeXmlString = new stdClass;
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a number value is provided', function () {
            $fakeXmlString = 11;
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if an array value is provided', function () {
            $fakeXmlString = ['<emit><CNPJ>28214544000175</CNPJ></emit>'];
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be return a failure Result if a bool string is provided', function () {
            $fakeXmlString = true;
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string fewer than fourteen letters is provided', function () {
            $fakeXmlString = '<emit><CNPJ>2821454400017</CNPJ></emit>';
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if an invalid value is provided', function () {
            $fakeXmlString = '<emit><CNPJ>28214544000176</CNPJ></emit>';
            $sut = CadastroPJ::parseXmlString($fakeXmlString);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::create()', function () {
        test('Should be return a Result object with success if a valid value is provided', function () {
            $fakeTagValue = '28214544000175';
            $sut = CadastroPJ::create($fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CadastroPJ::class);
            expect($sut->getData()->value)->toBeString();
        });

        test('Should be succeed if a tag value isn\'t provided', function () {
            $sut = CadastroPJ::create();
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeTruthy();
            expect($sut->getData())->toBeInstanceOf(CadastroPJ::class);
            expect($sut->getData()->value)->toBeString();
            expect($sut->getData()->value)->toBe('');
            expect($sut->getData()->xmlString)->toBeString();
            expect($sut->getData()->xmlString)->toBe('');
        });

        test('Should be fail if an invalid CNPJ value is provided', function () {
            $fakeTagValue = '00288867123';
            $sut = CadastroPJ::create($fakeTagValue);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if attributes is provided', function () {
            $fakeTagValue = '28214544000175';
            $fakeAttributes = ['fakeAttribute' => 'fakeAttributeValue'];
            $sut = CadastroPJ::create(tagValue: $fakeTagValue, attributes: $fakeAttributes);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if elements is provided', function () {
            $fakeTagValue = '28214544000175';
            $fakeElements = ['fakeElement'];
            $sut = CadastroPJ::create(tagValue: $fakeTagValue, elements: $fakeElements);
            expect($sut)->toBeInstanceOf(Result::class);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });

    describe('::validateTagValue()', function () {
        test('Should be true if provided value is a CNPJ', function () {
            $fakeTagValue = '28214544000175';
            $sut = CadastroPJ::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be succeed if a zero string is provided', function () {
            $fakeTagValue = '00000000000000';
            $sut = CadastroPJ::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeTruthy();
        });

        test('Should be fail if a string whit letters is provided', function () {
            $fakeTagValue = '28214544000175A';
            $sut = CadastroPJ::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a non-zero repeating numeric string is provided', function () {
            $fakeTagValue = '12345678901234';
            $sut = CadastroPJ::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
        });

        test('Should be fail if a string fewer than fourteen letters is provided', function () {
            $fakeTagValue = '2821454400017';
            $sut = CadastroPJ::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });

        test('Should be fail if a string more than fourteen letters is provided', function () {
            $fakeTagValue = '282145440001756';
            $sut = CadastroPJ::validateTagValue($fakeTagValue);
            expect($sut->isSuccess())->toBeFalsy();
            expect($sut->getError())->toBeInstanceOf(ValidationError::class);
        });
    });
});
