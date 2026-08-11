<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\AttributeKeyValidator;
use BradiApi\Domain\Xml\ValueObjects\Attribute;

describe('AttributeKeyValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\AttributeKeyValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the attribute name matches the expected key', function () {
                $sut = new AttributeKeyValidator('versao');
                $sutResponse = $sut->check(new Attribute('versao', '4.00'));

                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should succeed regardless of the attribute value', function (?string $value) {
                $sut = new AttributeKeyValidator('versao');
                $sutResponse = $sut->check(new Attribute('versao', $value));

                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'empty' => '',
                'null' => null,
            ]);

            test('Should fail if the attribute name does not match the expected key', function () {
                $sut = new AttributeKeyValidator('versao');
                $sutResponse = $sut->check(new Attribute('Id', 'NFe123'));

                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('Key attribute "versao" expected. "Id" found.');
            });

            test('Should fail if the candidate is not an Attribute', function (mixed $candidate) {
                $sut = new AttributeKeyValidator('versao');
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Attribute instance.');
            })->with([
                'string' => 'versao',
                'null' => null,
            ]);
        });
    });
});
