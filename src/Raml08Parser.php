<?php
/**
 * Created by PhpStorm.
 * User: dkarpinski
 * Date: 12.05.16
 * Time: 09:36
 */

namespace Madkom\Chimera\Parser\RAML08;

use Madkom\Chimera\Definition;
use Raml\Parser;

/**
 * Class Raml08Parser
 * @package Madkom\Chimera\Parser\RAML08
 */
class Raml08Parser implements RamlParserInterface
{

    /**
     * @param string $rawFileName
     * @return Definition
     */
    public function parse(string $rawFileName) : Definition
    {
        $parser = new Parser();
        $apiDefinition = $parser->parse($rawFileName);
        $definitionParser = new DefinitionParser();

        return $definitionParser->parse($apiDefinition);

    }

    /**
     * @param string $raml
     * @return Definition
     */
    public function parseFromString(string $raml) : Definition
    {
        $parser = new Parser();
        $apiDefinition = $parser->parseFromString($raml, '');
        $definitionParser = new DefinitionParser();

        return $definitionParser->parse($apiDefinition);
    }
}