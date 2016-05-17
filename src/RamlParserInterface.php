<?php
/**
 * Created by PhpStorm.
 * User: dkarpinski
 * Date: 12.05.16
 * Time: 13:40
 */

namespace Madkom\Chimera\Parser\RAML08;


use Madkom\Chimera\Definition;

interface RamlParserInterface
{
    public function parse(string $fileLocation) : Definition;
    public function parseFromString(string $raml) : Definition;
}