<?php
require __DIR__ . '/../vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(\BradiNfeApi\Tests\TestCase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
|
|
|expect()->extend('toBeOne', function () {
|    return $this->toBe(1);
|});
|
|
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function datasets(string ...$keyStrings): array
{
    return \BradiNfeApi\Tests\Doubles\Factories\DatasetFactory::generateByKeyStrings(...$keyStrings);
}

function xml_to_element(string $xmlString): \BradiNfeApi\Domain\Xml\ValueObjects\Element
{
    if ($xmlString === '') {
        return empty_element();
    }

    $document = new DOMDocument('1.0', 'UTF-8');
    $loaded = @$document->loadXML($xmlString);
    if (! $loaded || $document->documentElement === null) {
        return empty_element();
    }

    return dom_node_to_element($document->documentElement);
}

function empty_element(): \BradiNfeApi\Domain\Xml\ValueObjects\Element
{
    $element = new \BradiNfeApi\Domain\Xml\ValueObjects\Element(
        new \BradiNfeApi\Tests\Doubles\Domain\Xml\FakeXmlIterator,
        new \BradiNfeApi\Tests\Doubles\Domain\Common\FakeValidationService,
    );
    $element->name = '';
    $element->value = '';

    return $element;
}

function dom_node_to_element(DOMElement $domElement): \BradiNfeApi\Domain\Xml\ValueObjects\Element
{
    $element = new \BradiNfeApi\Domain\Xml\ValueObjects\Element(
        new \BradiNfeApi\Tests\Doubles\Domain\Xml\FakeXmlIterator,
        new \BradiNfeApi\Tests\Doubles\Domain\Common\FakeValidationService,
    );

    $element->name = $domElement->tagName;

    $value = '';
    foreach ($domElement->childNodes as $childNode) {
        if ($childNode->nodeType === XML_TEXT_NODE || $childNode->nodeType === XML_CDATA_SECTION_NODE) {
            $value .= $childNode->nodeValue ?? '';
        }

        if ($childNode instanceof DOMElement) {
            $element->addChild(dom_node_to_element($childNode));
        }
    }

    $element->value = $value;

    foreach ($domElement->attributes as $attribute) {
        $element->addAttribute(new \BradiNfeApi\Domain\Xml\ValueObjects\Attribute(
            $attribute->name,
            $attribute->value,
        ));
    }

    return $element;
}
