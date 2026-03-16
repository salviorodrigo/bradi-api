<?php

declare(strict_types=1);

use BradiNfeApi\Common\Protocols\ApiError;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\Destinatario;

describe('Destinatario', function () {
    $sut = Destinatario::class;

    describe('::parse()', function () use ($sut) {
        test('Should succeed with dataset :dataset', function ($candidate) use ($sut) {
            $sutResponse = $sut::parse($candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf($sut);
            expect($sutResponse->getData()->value)->toBe('');
            expect($sutResponse->getData()->xmlString)->toBe($candidate);
        })->with(datasets("dfes.nfe.element_tags.{$sut::$tagName}.valid"));

        test('Should fail with dataset :dataset', function ($candidate) use ($sut) {
            $sutResponse = $sut::parse($candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets("dfes.nfe.element_tags.{$sut::$tagName}.invalid"));
    });
});
