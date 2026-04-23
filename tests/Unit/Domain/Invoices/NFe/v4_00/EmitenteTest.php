<?php

declare(strict_types=1);

use BradiNfeApi\Tests\TestCase;
use BradiNfeApi\Domain\Common\Protocols\ApiError;
use BradiNfeApi\Domain\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Invoices\NFe\v4_00\Emitente;

describe('Emitente', function () {

    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new Emitente();
    });

    describe('::parse()', function () {
        test('Should succeed with dataset :dataset', function ($candidate) {
            $sutResponse = $this->sut->parse($candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isFailure()) {
                $this->fail(json_encode($sutResponse->getError()));
            }
            expect($sutResponse->getData())->toBeInstanceOf(Emitente::class);
            expect($sutResponse->getData()->value)->toBe('');
            expect($sutResponse->getData()->xmlString)->toBe($candidate);
        })->with(datasets("dfes.nfe.element_tags.".Emitente::TAG_NAME.".valid"));

        test('Should fail with dataset :dataset', function ($candidate) {
            $sutResponse = $this->sut->parse($candidate);
            expect($sutResponse)->toBeInstanceOf(Result::class);
            if ($sutResponse->isSuccess()) {
                $this->fail(json_encode($sutResponse->getData()));
            }
            expect($sutResponse)->toBeInstanceOf(Result::class);
            expect($sutResponse->getError())->toBeInstanceOf(ApiError::class);
        })->with(datasets("dfes.nfe.element_tags.".Emitente::TAG_NAME.".invalid"));
    });
});
