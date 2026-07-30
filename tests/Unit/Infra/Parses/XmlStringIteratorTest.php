<?php

declare(strict_types=1);

use BradiApi\Infra\Parses\XmlStringIterator;
use BradiApi\Tests\TestCase;
use Exception;

describe('XmlStringIterator', function () {
    describe('::loadFrom()', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new XmlStringIterator;
        });

        test('returns success with valid xml and keeps candidate', function () {
            $candidate = '<root id="10"><item>1</item></root>';

            $response = $this->sut->loadFrom($candidate);

            expect($response->isSuccess())->toBeTrue();
            expect($response->getData())->toBe($this->sut);
            expect($this->sut->candidate)->toBe($candidate);
        });

        test('returns failure when candidate is not a valid xml string', function () {
            $response = $this->sut->loadFrom(['invalid']);

            expect($response->isFailure())->toBeTrue();
        });

        test('returns failure when xml is malformed', function () {
            $response = $this->sut->loadFrom('<root><unclosed>');

            expect($response->isFailure())->toBeTrue();
        });
    });

    describe('public API without loaded candidate', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new XmlStringIterator;
        });

        test('throws when getting tag without loading candidate', function () {
            expect(fn () => $this->sut->get('item'))
                ->toThrow(Exception::class, 'Candidate not loaded.');
        });

        test('throws when listing tags without loading candidate', function () {
            expect(fn () => iterator_to_array($this->sut->list('item')))
                ->toThrow(Exception::class, 'Candidate not loaded.');
        });

        test('throws when reading computed properties without loading candidate', function () {
            expect(fn () => $this->sut->name)
                ->toThrow(Exception::class, 'Candidate not loaded.');

            expect(fn () => $this->sut->value)
                ->toThrow(Exception::class, 'Candidate not loaded.');

            expect(fn () => $this->sut->textContent)
                ->toThrow(Exception::class, 'Candidate not loaded.');

            expect(fn () => $this->sut->attributes)
                ->toThrow(Exception::class, 'Candidate not loaded.');

            expect(fn () => iterator_to_array($this->sut->children))
                ->toThrow(Exception::class, 'Candidate not loaded.');
        });
    });

    describe('::get() and ::list()', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new XmlStringIterator;
            $this->sut->loadFrom('<root><item>1</item><items>2</items><item>3</item></root>');
        });

        test('get returns the first matching tag', function () {
            expect($this->sut->get('item'))->toBe('<item>1</item>');
        });

        test('get returns empty string when tag does not exist', function () {
            expect($this->sut->get('unknown'))->toBe('');
        });

        test('list yields all matching tags in document order', function () {
            $items = iterator_to_array($this->sut->list('item'));

            expect($items)->toBe([
                '<item>1</item>',
                '<item>3</item>',
            ]);
        });

        test('list with empty tag name yields no records', function () {
            $items = iterator_to_array($this->sut->list(''));

            expect($items)->toBe([]);
        });

        test('list does not collide with prefixed tag names', function () {
            $items = iterator_to_array($this->sut->list('item'));

            expect($items)->not->toContain('<items>2</items>');
        });
    });

    describe('computed properties with loaded candidate', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new XmlStringIterator;
        });

        test('name returns root tag name', function () {
            $this->sut->loadFrom('<root id="10">x</root>');

            expect($this->sut->name)->toBe('root');
        });

        test('textContent returns inner xml including children', function () {
            $this->sut->loadFrom('<root>before<child>inside</child>after</root>');

            expect($this->sut->textContent)->toBe('before<child>inside</child>after');
        });

        test('value removes children xml from text content', function () {
            $this->sut->loadFrom('<root>before<child>inside</child>after</root>');

            expect($this->sut->value)->toBe('beforeafter');
        });

        test('attributes returns empty array when tag has no attributes', function () {
            $this->sut->loadFrom('<root>content</root>');

            expect($this->sut->attributes)->toBe([]);
        });

        test('attributes returns all simple attributes', function () {
            $this->sut->loadFrom('<root id="10" status="ok" type="nfe">content</root>');

            expect($this->sut->attributes)->toBe([
                'id' => '10',
                'status' => 'ok',
                'type' => 'nfe',
            ]);
        });

        test('children yields immediate child xml strings', function () {
            $this->sut->loadFrom('<root><a>1</a><b><c>2</c></b></root>');

            $children = iterator_to_array($this->sut->children);

            expect($children)->toBe([
                '<a>1</a>',
                '<b><c>2</c></b>',
            ]);
        });

        test('textContent and value are empty for self-closing tag', function () {
            $this->sut->loadFrom('<item id="1"/>');

            expect($this->sut->textContent)->toBe('');
            expect($this->sut->value)->toBe('');
        });
    });

    describe('regression scenarios', function () {
        beforeEach(function () {
            /** @var TestCase $this */
            $this->sut = new XmlStringIterator;
        });

        test('keeps non-self-closing tag even when attribute contains slash', function () {
            $this->sut->loadFrom('<root path="c:/folder">ok</root>');

            expect($this->sut->textContent)->toBe('ok');
            expect($this->sut->value)->toBe('ok');
        });

        test('handles nested tags with the same name when listing children tag from root', function () {
            $this->sut->loadFrom('<root><item>outer<item>inner</item></item></root>');

            $items = iterator_to_array($this->sut->list('item'));

            expect($items)->toHaveCount(1);
            expect($items[0])->toBe('<item>outer<item>inner</item></item>');
        });
    });
});
