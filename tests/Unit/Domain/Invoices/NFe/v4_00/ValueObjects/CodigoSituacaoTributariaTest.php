<?php

declare(strict_types=1);

use BradiNfeApi\Common\Protocols\ApiError;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoSituacaoTributaria;
use BradiNfeApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElement;

describe('CodigoSituacaoTributaria', function () {
    $sut = CodigoSituacaoTributaria::class;

    describe('::parse()', function () use ($sut) {
        test('Should succeed with dataset :dataset', function ($candidate) use ($sut) {
            $xmlString = $candidate === '' ? '' : "<{$sut::$tagName}>{$candidate}</{$sut::$tagName}>";
            $sutResponse = $sut::parse($xmlString);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf($sut);
            expect($sutResponse->getData()->value)->toBe($candidate);
            expect($sutResponse->getData()->xmlString)->toBe($xmlString);
        })->with(datasets("dfes.nfe.value_tags.{$sut::$tagName}.valid"));

        test('Should fail with data set :dataset', function ($candidate) use ($sut) {
            $xmlString = "<{$sut::$tagName}>{$candidate}</{$sut::$tagName}>";
            $sutResponse = $sut::parse($xmlString);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets("dfes.nfe.value_tags.{$sut::$tagName}.invalid"));

        test('Should fail if attributes is provided', function ($candidate) use ($sut) {
            $xmlString = "<{$sut::$tagName} fake=\"attribute\">{$candidate}</{$sut::$tagName}>";
            $sutResponse = $sut::parse($xmlString);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets("dfes.nfe.value_tags.{$sut::$tagName}.valid"));

        test('Should fail if elements is provided', function ($candidate) use ($sut) {
            $xmlString = "<{$sut::$tagName}>{$candidate}<fake>element</fake></{$sut::$tagName}>";
            $sutResponse = $sut::parse($xmlString);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets("dfes.nfe.value_tags.{$sut::$tagName}.valid"));
    });

    describe('::create()', function () use ($sut) {
        test('Should succeed with $tagValue dataset :dataset', function ($candidate) use ($sut) {
            $xmlString = $candidate === '' ? '' : "<{$sut::$tagName}>{$candidate}</{$sut::$tagName}>";
            $sutResponse = $sut::create((string) $candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf($sut);
            expect($sutResponse->getData()->value)->toBe($candidate);
            expect($sutResponse->getData()->xmlString)->toBe($xmlString);
        })->with(datasets("dfes.nfe.value_tags.{$sut::$tagName}.valid"));

        test('Should fail when $tagValue is :dataset', function ($candidate) use ($sut) {
            $sutResponse = $sut::create((string) $candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets(
            "dfes.nfe.value_tags.{$sut::$tagName}.invalid",
            'xmls.valid.standard.simple'
        ));

        test('Should fail when $tagValue is valid but elements are provided', function ($candidate) use ($sut) {
            $fakeElement = new FakeDFeElement;
            $sutResponse = $sut::create((string) $candidate, elements: [$fakeElement]);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode(['input' => ['tagValue' => $candidate, 'elements' => [$fakeElement]], 'response' => $sutResponse->getData()]));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets("dfes.nfe.value_tags.{$sut::$tagName}.valid"));

        test('Should fail if attributes is provided', function ($candidate) use ($sut) {
            $fakeAttributes = ['fakeAttribute' => 'fakeValue'];
            $sutResponse = $sut::create((string) $candidate, attributes: $fakeAttributes);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets("dfes.nfe.value_tags.{$sut::$tagName}.valid"));

        test('Should throw with dataset :dataset', function ($candidate) use ($sut) {
            $sut::create($candidate);
        })->with(datasets(
            'non_stringable'
        ))->throws(TypeError::class);
    });
});
