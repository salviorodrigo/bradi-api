<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Validators\RootTagValidator;
use BradiApi\Domain\Xml\ValueObjects\Element;

describe('RootTagValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Invoices\Validators';
        $sut = $nameSpace . '\\RootTagValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if the root tag matches the expected name', function () {
                $element = new Element;
                $element->parse('<emit><CNPJ>04840356000194</CNPJ></emit>');

                $sut = new RootTagValidator('emit');
                $sutResponse = $sut->check($element);

                expect($sutResponse)->toBeInstanceOf(Result::class);
                expect($sutResponse->isSuccess())->toBeTrue();
            });

            test('Should fail if the root tag does not match the expected name', function () {
                $element = new Element;
                $element->parse('<dest><CNPJ>04840356000194</CNPJ></dest>');

                $sut = new RootTagValidator('emit');
                $sutResponse = $sut->check($element);

                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('Tag "emit" expected. "dest" found.');
            });

            test('Should fail if the element has no name', function () {
                $sut = new RootTagValidator('emit');
                $sutResponse = $sut->check(new Element);

                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('Tag "emit" expected.');
            });

            test('Should fail if the candidate is not an Element', function (mixed $candidate) {
                $sut = new RootTagValidator('emit');
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('candidate must be an Element instance.');
            })->with([
                'string' => '<emit/>',
                'null' => null,
            ]);
        });
    });
});
