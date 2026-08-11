<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Validators\IsXmlStringValidator;
use BradiApi\Domain\Common\ValueObjects\Result;

describe('IsXmlStringValidator', function () {
    test('Should succeed if is declared', function () {
        $nameSpace = 'BradiApi\Domain\Common\Validators';
        $sut = $nameSpace . '\\IsXmlStringValidator';
        expect(class_exists($sut))->toBeTrue();
    });

    describe('methods', function () {
        describe('check()', function () {
            test('Should succeed if a valid XML string is provided', function (string $candidate) {
                $sut = new IsXmlStringValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse)->toBeInstanceOf(Result::class);
                if ($sutResponse->isFailure()) {
                    $this->fail($sutResponse->getError()->getMessage());
                }
                expect($sutResponse->isSuccess())->toBeTrue();
            })->with([
                'tag_with_value' => '<tag>aValue</tag>',
                'auto_close_tag' => '<tag/>',
                'tag_with_attribute' => '<tag attribute="aValue"/>',
                'nested_tags' => '<root><tag>aValue</tag></root>',
            ]);

            test('Should fail if an invalid XML string is provided', function (string $candidate) {
                $sut = new IsXmlStringValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a valid XML string.');
            })->with([
                'unclosed_tag' => '<tag>aValue',
                'mismatched_tags' => '<tag>aValue</other>',
                'plain_text' => 'aValue',
                'empty' => '',
            ]);

            test('Should fail if a non-string is provided', function (mixed $candidate) {
                $sut = new IsXmlStringValidator;
                $sutResponse = $sut->check($candidate);
                expect($sutResponse->isFailure())->toBeTrue();
                expect($sutResponse->getError()->getMessage())->toBe('must be a valid XML string.');
            })->with([
                'integer' => 1058,
                'array' => [['<tag/>']],
                'null' => null,
            ]);
        });
    });
});
