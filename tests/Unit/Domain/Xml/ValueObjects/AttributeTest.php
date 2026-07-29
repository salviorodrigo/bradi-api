<?php

declare(strict_types=1);

use BradiApi\Domain\Xml\ValueObjects\Attribute;

describe('Attribute', function () {
    describe('::__construct()', function () {
        test('sets name value and parent tag name as readonly properties', function () {
            $sut = new Attribute('id', '123', 'item');

            expect($sut->name)->toBe('id');
            expect($sut->value)->toBe('123');
            expect($sut->parentTagName)->toBe('item');
        });
    });

    describe('::__toString()', function () {
        test('serializes attribute name and value', function () {
            $sut = new Attribute('id', '123', 'item');

            expect((string) $sut)->toBe('id="123"');
        });

        test('escapes ampersand in value', function () {
            $sut = new Attribute('ref', 'A&B', 'item');

            expect((string) $sut)->toBe('ref="A&amp;B"');
        });

        test('escapes less-than and greater-than in value', function () {
            $sut = new Attribute('expr', '5 < 7 > 3', 'item');

            expect((string) $sut)->toBe('expr="5 &lt; 7 &gt; 3"');
        });

        test('escapes single and double quotes in value', function () {
            $sut = new Attribute('message', 'it\'s "ok"', 'item');

            expect((string) $sut)->toBe('message="it&apos;s &quot;ok&quot;"');
        });
    });
});
