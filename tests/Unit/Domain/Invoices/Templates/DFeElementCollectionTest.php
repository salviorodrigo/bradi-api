<?php

declare(strict_types=1);

use BradiApi\Domain\Common\Protocols\ApiError;
use BradiApi\Domain\Common\Protocols\Validator;
use BradiApi\Domain\Common\ValueObjects\Result;
use BradiApi\Domain\Invoices\Templates\DFeElementCollection;
use BradiApi\Domain\Xml\ValueObjects\Element;
use BradiApi\Domain\Xml\ValueObjects\ElementList;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElement;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElementCollection;
use BradiApi\Tests\TestCase;

describe('DFeElementCollection', function () {
    beforeEach(function () {
        /** @var TestCase $this */
        $this->sut = new FakeDFeElementCollection('infNFe');
    });

    $makeElement = function (string $name, ?string $value = null): Element {
        $element = new Element;
        $element->name = $name;
        $element->value = $value;

        return $element;
    };

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

        test('Should throw when FIELD_NAME constant is not defined in child class', function () {
            expect(fn () => new class extends DFeElementCollection
            {
                protected const string BASE_CLASS = FakeDFeElement::class;

                protected const string FIELD_NAME = '';

                protected function collectionValidators(): array
                {
                    return [];
                }
            })->toThrow(Exception::class, 'FIELD_NAME constant must be defined in the child class.');
        });
    });

    describe('::parse()', function () use ($makeElement) {
        test('Should succeed parsing single Element', function () {
            $candidate = '<FakeTag>first</FakeTag>';
            $element = new Element;
            $parsingResult = $element->parse($candidate);
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }

            $parsingResponse = $this->sut->parse($parsingResult->getData());
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect($parsingResponse->getData())->toBe($this->sut);
            expect(count($this->sut->collection))->toBe(1);
            expect($this->sut->collection[0])->toBeInstanceOf(FakeDFeElement::class);
            expect($this->sut->collection[0]->value)->toBe('first');
        });

        test('Should succeed parsing ElementList with many elements', function () use ($makeElement) {
            $firstElement = $makeElement('FakeTag', 'first');
            $secondElement = $makeElement('FakeTag', 'second');

            $parsingResponse = $this->sut->parse(new ElementList([$firstElement, $secondElement]));
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect(count($this->sut->collection))->toBe(2);
            expect($this->sut->collection[0])->toBeInstanceOf(FakeDFeElement::class);
            expect($this->sut->collection[1])->toBeInstanceOf(FakeDFeElement::class);
            expect($this->sut->collection[0]->value)->toBe('first');
            expect($this->sut->collection[1]->value)->toBe('second');
        });

        test('Should build an independent DFeElement instance per parsed Element', function () use ($makeElement) {
            $parsingResponse = $this->sut->parse(new ElementList([
                $makeElement('FakeTag', 'first'),
                $makeElement('FakeTag', 'second'),
            ]));
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect($this->sut->collection[0])->not->toBe($this->sut->collection[1]);
        });

        test('Should prefix the parent field URI on every parsed item', function () use ($makeElement) {
            $parsingResponse = $this->sut->parse($makeElement('FakeTag', 'first'));
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect($this->sut->collection[0]->fieldURI)->toBe('infNFe.FakeTag');
        });

        test('Should ignore elements whose name differs from the BASE_CLASS FIELD_NAME', function () {
            $candidate = '<root><FakeTag>first</FakeTag><WrongTag>second</WrongTag></root>';
            $element = new Element;

            $parsingResult = $element->parse($candidate);
            if ($parsingResult->isFailure()) {
                $this->fail(json_encode($parsingResult->getError()));
            }

            $elements = $parsingResult->getData()->children->records;
            $parsingResponse = $this->sut->parse(new ElementList($elements));
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect(count($this->sut->collection))->toBe(1);
            expect($this->sut->collection[0]->value)->toBe('first');
        });

        test('Should succeed with empty ElementList', function () {
            $parsingResponse = $this->sut->parse(new ElementList);
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isFailure()) {
                $this->fail(json_encode($parsingResponse->getError()));
            }

            expect(count($this->sut->collection))->toBe(0);
        });

        test('Should fail and reset the collection when a collection validator rejects', function () use ($makeElement) {
            $sut = new class('infNFe') extends DFeElementCollection
            {
                protected const string BASE_CLASS = FakeDFeElement::class;

                protected const string FIELD_NAME = 'fakeTag';

                protected function collectionValidators(): array
                {
                    return [
                        new class implements Validator
                        {
                            public function check(mixed $candidate): Result
                            {
                                return Result::makeFailure(new InvalidArgumentException('collection is not allowed.'));
                            }
                        },
                    ];
                }
            };

            $parsingResponse = $sut->parse(new ElementList([
                $makeElement('FakeTag', 'first'),
            ]));
            expect($parsingResponse)->toBeInstanceOf(Result::class);
            if ($parsingResponse->isSuccess()) {
                $this->fail(json_encode($parsingResponse->getData()));
            }

            expect($parsingResponse->getError())->toBeInstanceOf(ApiError::class);
            expect($sut->collection)->toBe([]);
        });
    });

    describe('::toString()', function () use ($makeElement) {
        beforeEach(function () {
            /** @var TestCase $this */
            $element = new Element;
            $element->parse('<FakeTag>first</FakeTag>');
            $this->sut->parse($element);
        });

        test('Should serialize every item of the collection in order', function () {
            expect($this->sut->toString())->toBe('<FakeTag>first</FakeTag>');
        });

        test('Should serialize many items preserving the collection order', function () use ($makeElement) {
            $sut = new FakeDFeElementCollection('infNFe');
            $sut->parse(new ElementList([
                $makeElement('FakeTag', 'first'),
                $makeElement('FakeTag', 'second'),
            ]));

            expect($sut->toString())->toBe('<FakeTag>first</FakeTag><FakeTag>second</FakeTag>');
        });

        test('Should return an empty string when nothing was parsed', function () {
            $sut = new FakeDFeElementCollection('infNFe');

            expect($sut->toString())->toBe('');
        });

        test('Should reflect a value changed on a parsed item', function () {
            $this->sut->collection[0]->value = 'updated';

            expect($this->sut->toString())->toBe('<FakeTag>updated</FakeTag>');
        });

        test('Should reflect an item appended to the collection', function () {
            $appended = new FakeDFeElement('infNFe');
            $appended->value = 'second';
            $this->sut->collection[] = $appended;

            expect($this->sut->toString())->toBe('<FakeTag>first</FakeTag><FakeTag>second</FakeTag>');
        });

        test('Should reflect an item removed from the collection', function () {
            $this->sut->collection = [];

            expect($this->sut->toString())->toBe('');
        });

        test('Should skip items that have no XML representation', function () {
            $this->sut->collection[] = new FakeDFeElement('infNFe');

            expect($this->sut->toString())->toBe('<FakeTag>first</FakeTag>');
        });

        test('Should be idempotent across consecutive calls', function () {
            expect($this->sut->toString())->toBe($this->sut->toString());
        });
    });

    describe('::__toString()', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $element = new Element;
            $element->parse('<FakeTag>first</FakeTag>');
            $this->sut->parse($element);
        });

        test('Should delegate the serialization to ::toString()', function () {
            expect((string) $this->sut)->toBe($this->sut->toString());
        });

        test('Should serialize every item of the collection in order', function () {
            expect((string) $this->sut)->toBe('<FakeTag>first</FakeTag>');
        });

        test('Should reflect a value changed on a parsed item', function () {
            $this->sut->collection[0]->value = 'updated';

            expect((string) $this->sut)->toBe('<FakeTag>updated</FakeTag>');
        });

        test('Should reflect an item appended to the collection', function () {
            $appended = new FakeDFeElement('infNFe');
            $appended->value = 'second';
            $this->sut->collection[] = $appended;

            expect((string) $this->sut)->toBe('<FakeTag>first</FakeTag><FakeTag>second</FakeTag>');
        });

        test('Should reflect an item removed from the collection', function () {
            $this->sut->collection = [];

            expect((string) $this->sut)->toBe('');
        });
    });
});
