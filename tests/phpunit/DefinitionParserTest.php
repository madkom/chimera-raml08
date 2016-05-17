<?php
/**
 * Created by PhpStorm.
 * User: dkarpinski
 * Date: 12.05.16
 * Time: 10:07
 */

namespace Madkom\Chimera\Parser\RAML08\Tests;

use Madkom\Chimera\Parser\RAML08\Raml08Parser;
use Madkom\Uri\UriTemplate;
use PHPUnit_Framework_TestCase;

/**
 * Class DefinitionParserTest
 * @package Madkom\Chimera\Parser\RAML08\Tests
 */
class DefinitionParserTest extends PHPUnit_Framework_TestCase
{
    private $raml08Parser;

    public function setUp()
    {
        parent::setUp();
        $this->raml08Parser = new Raml08Parser();
    }

    /** @test */
    public function shouldLoadDefinition()
    {
        $raml = <<<RAML
#%RAML 0.8
title: ZEncoder API
documentation:
 - title: Home
   content: |
     Welcome to the _Zencoder API_ Documentation. The _Zencoder API_
     allows you to connect your application to our encoding service
     and encode videos without going through the web  interface. You
     may also benefit from one of our
     [integration libraries](https://app.zencoder.com/docs/faq/basics/libraries)
     for different languages.
version: v2
baseUri: https://app.zencoder.com/api/{version}
RAML;
        $definition = $this->raml08Parser->parseFromString($raml);

        $this->assertEquals('ZEncoder API', $definition->getTitle());
        $this->assertEquals(new UriTemplate('https://app.zencoder.com/api/v2'), $definition->getBasePath());
        $this->assertEquals('v2', $definition->getVersion());
    }

    /** @test */
    public function shouldLoadWithOnlyTitle()
    {
        $raml = <<<RAML
#%RAML 0.8
title: ZEncoder API
RAML;
        $definition = $this->raml08Parser->parseFromString($raml);

        $this->assertEquals('ZEncoder API', $definition->getTitle());
    }
}