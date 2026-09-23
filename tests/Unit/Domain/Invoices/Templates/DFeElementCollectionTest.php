<?php

declare(strict_types=1);

use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElement;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElementCollection;
use BradiApi\Tests\TestCase;

describe('DFeElementCollection', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeElementCollection('FakeTag');
    });

    test('Should be declared as abstract', function () {
        $sut = new ReflectionClass(DFeElementCollection::class);
        expect($sut->isAbstract())->toBeTrue();
    });

    describe('::__construct()', function () {
        test('Should succeed when the child class declares BASE_CLASS and FIELD_NAME', function () {
            expect(fn () => new FakeDFeElementCollection('infNFe'))->not->toThrow(Throwable::class);
        });

        test('Should throw when BASE_CLASS constant is not defined in child class', function () {
            expect(fn () => new class extends DFeElementCollection
            {
                protected const string BASE_CLASS = '';

                protected const string FIELD_NAME = 'fakeTag';

                protected function collectionValidators(): array
                {
                    return [];
                }
            })->toThrow(Exception::class, 'BASE_CLASS constant must be defined in the child class.');
        });

        test('Should throw when BASE_CLASS is not a subclass of DFeElement', function () {
            expect(fn () => new class extends DFeElementCollection
            {
                protected const string BASE_CLASS = Element::class;

                protected const string FIELD_NAME = 'fakeTag';

                protected function collectionValidators(): array
                {
                    return [];
                }
            })->toThrow(Exception::class, 'BASE_CLASS must be a subclass of DFeElement.');
        });
    });

    describe('::parse()', function () {
        test('Should fail if the provided element does not contain at least one sut element', function () {
            $candidate = '<parentElement><childElement>value</childElement></parentElement>';
            $parentElement = new Element;
            $elementParsingResult = $parentElement->parse($candidate);
            if ($elementParsingResult->isFailure()) {
                $this->fail(json_encode($elementParsingResult->getError()));
            }

            $sutParsingResult = $this->sut->parse($parentElement);
            expect($sutParsingResult)->toBeInstanceOf(Result::class);
            if ($sutParsingResult->isSuccess()) {
                $this->fail(json_encode($sutParsingResult->getData()));
            }
            expect($sutParsingResult->isFailure())->toBeTruthy();
        });

        test('Should succeed parsing a parent element with a single sut element', function () {
            $candidate = '<parentElement><FakeTag>first</FakeTag></parentElement>';
            $parentElement = new Element;
            $elementParsingResult = $parentElement->parse($candidate);
            if ($elementParsingResult->isFailure()) {
                $this->fail(json_encode($elementParsingResult->getError()));
            }

            $sutParsingResult = $this->sut->parse($parentElement);
            expect($sutParsingResult)->toBeInstanceOf(Result::class);
            if ($sutParsingResult->isFailure()) {
                $this->fail(json_encode($sutParsingResult->getError()));
            }

            expect($sutParsingResult->getData())->toBe($this->sut);
            expect(count($this->sut->collection))->toBe(1);
            expect($this->sut->collection[0])->toBeInstanceOf(FakeDFeElement::class);
            expect($this->sut->collection[0]->value)->toBe('first');
        });

        test('Should succeed parsing a parent element with many sut elements', function () {
            $candidate = '<parentElement><FakeTag>first</FakeTag><FakeTag>second</FakeTag></parentElement>';
            $parentElement = new Element;
            $elementParsingResult = $parentElement->parse($candidate);
            if ($elementParsingResult->isFailure()) {
                $this->fail(json_encode($elementParsingResult->getError()));
            }

            $sutParsingResult = $this->sut->parse($parentElement);
            expect($sutParsingResult)->toBeInstanceOf(Result::class);
            if ($sutParsingResult->isFailure()) {
                $this->fail(json_encode($sutParsingResult->getError()));
            }

            expect(count($this->sut->collection))->toBe(2);
            expect($this->sut->collection[0])->toBeInstanceOf(FakeDFeElement::class);
            expect($this->sut->collection[1])->toBeInstanceOf(FakeDFeElement::class);
            expect($this->sut->collection[0]->value)->toBe('first');
            expect($this->sut->collection[1]->value)->toBe('second');
        });

        test('Should prefix the parent field URI on every parsed item', function () {
            $candidate = '<parentElement><FakeTag>first</FakeTag><FakeTag>second</FakeTag></parentElement>';
            $parentElement = new Element;
            $elementParsingResult = $parentElement->parse($candidate);
            if ($elementParsingResult->isFailure()) {
                $this->fail(json_encode($elementParsingResult->getError()));
            }
            $sutParsingResult = $this->sut->parse($parentElement);
            expect($sutParsingResult)->toBeInstanceOf(Result::class);
            if ($sutParsingResult->isFailure()) {
                $this->fail(json_encode($sutParsingResult->getError()));
            }
            expect($this->sut->collection[0]->fieldURI)->toBe('FakeTag.FakeTag');
        });

        test('Should ignore elements whose name differs from the BASE_CLASS FIELD_NAME', function () {
            $candidate = '<parentElement><FakeTag>first</FakeTag><WrongTag>second</WrongTag></parentElement>';
            $parentElement = new Element;

            $elementParsingResult = $parentElement->parse($candidate);
            if ($elementParsingResult->isFailure()) {
                $this->fail(json_encode($elementParsingResult->getError()));
            }

            $sutParsingResult = $this->sut->parse($parentElement);
            expect($sutParsingResult)->toBeInstanceOf(Result::class);
            if ($sutParsingResult->isFailure()) {
                $this->fail(json_encode($sutParsingResult->getError()));
            }

            expect(count($this->sut->collection))->toBe(1);
            expect($this->sut->collection[0]->value)->toBe('first');
        });
    });

    describe('::__toString()', function () {
        test('Should serialize every item of the collection in order', function () {
            $candidate = '<parentElement><FakeTag>first</FakeTag><WrongTag>second</WrongTag></parentElement>';
            $parentElement = new Element;

            $elementParsingResult = $parentElement->parse($candidate);
            if ($elementParsingResult->isFailure()) {
                $this->fail(json_encode($elementParsingResult->getError()));
            }

            $sutParsingResult = $this->sut->parse($parentElement);
            if ($sutParsingResult->isFailure()) {
                $this->fail(json_encode($sutParsingResult->getError()));
            }

            expect($this->sut->toString())->toBe('<FakeTag>first</FakeTag>');
        });

        test('Should serialize many items preserving the collection order', function () {
            $sut = new FakeDFeElementCollection('infNFe');
            $parentElement = new Element;
            $candidate = '<parentElement><FakeTag>first</FakeTag><FakeTag>second</FakeTag></parentElement>';

            $elementParsingResult = $parentElement->parse($candidate);
            if ($elementParsingResult->isFailure()) {
                $this->fail(json_encode($elementParsingResult->getError()));
            }

            $sutParsingResult = $sut->parse($parentElement);
            if ($sutParsingResult->isFailure()) {
                $this->fail(json_encode($sutParsingResult->getError()));
            }

            expect($sut->toString())->toBe('<FakeTag>first</FakeTag><FakeTag>second</FakeTag>');
        });

        test('Should return an empty string when nothing was parsed', function () {
            $sut = new FakeDFeElementCollection;

            expect($sut->toString())->toBe('');
        });
    });
});
