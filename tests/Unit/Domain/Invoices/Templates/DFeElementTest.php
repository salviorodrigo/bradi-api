<?php

declare(strict_types=1);

use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeAttribute;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeElement;
use BradiApi\Tests\Doubles\Domain\Invoices\NFe\FakeDFeGroupWithAttribute;

describe('DFeElement', function () {
    describe('::__toString()', function () {
        test('Should serialize xml string from cache when already set', function () {
            $sut = new FakeDFeElement;
            $sut->value = 'hello';

            expect((string) $sut)->toBe('<FakeTag>hello</FakeTag>');
        });

        test('Should serialize group with child DFeElement', function () {
            $child = new FakeDFeElement;
            $child->value = 'childValue';

            $sut = new FakeDFeGroupWithAttribute;
            $sut->fakeAttr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
            $sut->fakeAttr->value = 'attrValue';
            $sut->fakeChild = $child;

            expect((string) $sut)->toBe('<FakeGroup fakeAttr="attrValue"><FakeTag>childValue</FakeTag></FakeGroup>');
        });

        test('Should include attribute in opening tag', function () {
            $attr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
            $attr->value = 'ABC123';

            $child = new FakeDFeElement('x');

            $sut = new FakeDFeGroupWithAttribute;
            $sut->fakeAttr = $attr;
            $sut->fakeChild = $child;

            $result = (string) $sut;

            expect($result)->toStartWith('<FakeGroup fakeAttr="ABC123">');
        });

        test('Should skip optional child when not initialized', function () {
            $attr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
            $attr->value = 'attrValue';

            $child = new FakeDFeElement;
            $child->value = 'childValue';

            $sut = new FakeDFeGroupWithAttribute;
            $sut->fakeAttr = $attr;
            $sut->fakeChild = $child;
            // fakeOptionalChild is intentionally not initialized

            $result = (string) $sut;

            expect($result)->toBe('<FakeGroup fakeAttr="attrValue"><FakeTag>childValue</FakeTag></FakeGroup>');
        });

        test('Should skip optional child when null', function () {
            $attr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
            $attr->value = 'attrValue';

            $child = new FakeDFeElement;
            $child->value = 'childValue';

            $sut = new FakeDFeGroupWithAttribute;
            $sut->fakeAttr = $attr;
            $sut->fakeChild = $child;
            $sut->fakeOptionalChild = null;

            $result = (string) $sut;

            expect($result)->toBe('<FakeGroup fakeAttr="attrValue"><FakeTag>childValue</FakeTag></FakeGroup>');
        });

        test('Should throw RuntimeException when required DFeElement property is not initialized', function () {
            $sut = new FakeDFeGroupWithAttribute;
            $sut->fakeAttr = new FakeDFeAttribute('FakeDFeGroupWithAttribute');
            $sut->fakeAttr->value = 'attrValue';
            // fakeChild intentionally not initialized

            expect(fn () => (string) $sut)->toThrow(RuntimeException::class);
        });

        test('Should throw RuntimeException when required DFeAttribute property is not initialized', function () {
            $sut = new FakeDFeGroupWithAttribute;
            // fakeAttr intentionally not initialized

            expect(fn () => (string) $sut)->toThrow(RuntimeException::class);
        });
    });
});
