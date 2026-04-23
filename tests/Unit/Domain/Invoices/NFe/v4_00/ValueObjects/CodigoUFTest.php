<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\CodigoUF;

describe('CodigoUF', function () {
    $sut = CodigoUF::class;

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
});
