<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\ValueObjects\QuantidadeComercial;
use BradiNfeApi\Tests\TestCase;

describe('QuantidadeComercial', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new QuantidadeComercial('');
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $xmlString = $candidate === '' ? '' : '<' . QuantidadeComercial::TAG_NAME . ">{$candidate}</" . QuantidadeComercial::TAG_NAME . '>';
            $sutResponse = $this->sut->parse($xmlString);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(QuantidadeComercial::class);
            expect($sutResponse->getData()->value)->toBe($candidate);
            expect($sutResponse->getData()->xmlString)->toBe($xmlString);
        })->with(datasets('dfes.nfe.value_tags.' . QuantidadeComercial::TAG_NAME . '.valid'));

        test('Should fail with data set :dataset', function ($candidate) {
            $xmlString = '<' . QuantidadeComercial::TAG_NAME . ">{$candidate}</" . QuantidadeComercial::TAG_NAME . '>';
            $sutResponse = $this->sut->parse($xmlString);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . QuantidadeComercial::TAG_NAME . '.invalid'));

        test('Should fail if attributes is provided', function ($candidate) {
            $xmlString = '<' . QuantidadeComercial::TAG_NAME . " fake=\"attribute\">{$candidate}</" . QuantidadeComercial::TAG_NAME . '>';
            $sutResponse = $this->sut->parse($xmlString);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . QuantidadeComercial::TAG_NAME . '.valid'));

        test('Should fail if elements is provided', function ($candidate) {
            $xmlString = '<' . QuantidadeComercial::TAG_NAME . ">{$candidate}<fake>element</fake></" . QuantidadeComercial::TAG_NAME . '>';
            $sutResponse = $this->sut->parse($xmlString);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.value_tags.' . QuantidadeComercial::TAG_NAME . '.valid'));
    });
});
