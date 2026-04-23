<?php

declare(strict_types=1);

use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\EnderecoDestinatario;
use BradiNfeApi\Tests\TestCase;

describe('EnderecoDestinatario', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new EnderecoDestinatario;
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $sutResponse = $this->sut->parse($candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(EnderecoDestinatario::class);
            expect($sutResponse->getData()->value)->toBe('');
            expect($sutResponse->getData()->xmlString)->toBe($candidate);
        })->with(datasets('dfes.nfe.element_tags.' . EnderecoDestinatario::TAG_NAME . '.valid'));

        test('Should fail with dataset :dataset', function ($candidate) {
            $sutResponse = $this->sut->parse($candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets('dfes.nfe.element_tags.' . EnderecoDestinatario::TAG_NAME . '.invalid'));
    });
});
