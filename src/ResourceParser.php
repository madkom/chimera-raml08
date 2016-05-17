<?php
/**
 * Created by PhpStorm.
 * User: dkarpinski
 * Date: 12.05.16
 * Time: 13:39
 */

namespace Madkom\Chimera\Parser\RAML08;

use Madkom\Chimera\Entity;
use Madkom\Chimera\Resource\Header;
use Madkom\Chimera\Resource\Method;
use Madkom\RegEx\Pattern;
use Madkom\Uri\UriTemplate;
use Raml\NamedParameter;
use Raml\Resource;

class ResourceParser
{

    /**
     * @param Resource $_resource
     * @return \Madkom\Chimera\Resource
     */
    public function parse(Resource $_resource) : \Madkom\Chimera\Resource
    {
        $methods = [];
        foreach ($_resource->getMethods() as $_method) {

            $methods[] = $this->parseMethod($_method);
        }

        $resource = new \Madkom\Chimera\Resource(new UriTemplate($_resource->getUri()), $methods);

        return $resource;
    }

    /**
     * @param \Raml\Method $_method
     * @return Method
     */
    public function parseMethod(\Raml\Method $_method) : Method
    {
        $method = new Method($_method->getType());

        foreach ($_method->getHeaders() as $_header) {

            $method->addHeader($this->parseHeader($_header));
        }

        return $method;
    }


    /**
     * @param NamedParameter $_header
     * @return Header
     */
    public function parseHeader(NamedParameter $_header) : Header
    {
        $header = new Header($_header->getKey());
        $header->setDescription($_header->getDescription());
        $header->setRequired($_header->isRequired());
        foreach ($_header->getExamples() as $example) {
            $header->addExample($example);
        }

        if ($_header->getValidationPattern()) {

            $header->setPattern(new Pattern($_header->getValidationPattern()));
        }

        return $header;
    }
}