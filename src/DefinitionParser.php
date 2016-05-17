<?php
/**
 * Created by PhpStorm.
 * User: dkarpinski
 * Date: 12.05.16
 * Time: 09:57
 */

namespace Madkom\Chimera\Parser\RAML08;

use Madkom\Chimera\Definition;
use Madkom\Chimera\Documentation;
use Madkom\Uri\UriTemplate;
use Raml\ApiDefinition;
use Raml\Resource;

/**
 * Class DefinitionParser
 * @package Madkom\Chimera\Parser\RAML08
 */
class DefinitionParser
{

    /**
     * @param ApiDefinition $apiDefinition
     * @return Definition
     */
    public function parse(ApiDefinition $apiDefinition)
    {
        $definition = new Definition();


        if ($apiDefinition->getTitle()) {
            $definition->setTitle($apiDefinition->getTitle());
        }

        if ($apiDefinition->getVersion()) {
            $definition->setVersion($apiDefinition->getVersion());
        }

        if ($apiDefinition->getDocumentationList() != NULL) {
            foreach ($apiDefinition->getDocumentationList() as $documentation) {
                $definition->addDocumentation(new Documentation($documentation['title'], $documentation['content']));
            }
        }

        if ($apiDefinition->getBaseUrl())
        {

            $definition->setBasePath(new UriTemplate($apiDefinition->getBaseUrl()));
        }

        foreach($this->parseResources($apiDefinition->getResources()) as $resource) {

            $definition->addResource($resource);
        }

        return $definition;
    }

    /**
     * Rekurencyjna funkcja to parsowania zagnieżdżonych zasobów z Raml/Resourde do tablicy obiektów Madkon/Chimera/Resource
     * @param $resources
     * @return array|\Madkom\Chimera\Resource
     */
    protected function parseResources($resources)
    {
        if (is_array($resources)) {
            $_resources = [];
            foreach ($resources as $resource) {
                $parsed = $this->parseResources($resource);
                if (is_array($parsed)) {
                    $_resources = array_merge($_resources, $parsed);
                } else {
                    $_resources[] = $parsed;
                }
            }

            return $_resources;

        } elseif ($resources instanceof Resource) {
            $resourceParser = new ResourceParser();

            if ($resources->getResources()) {

                $_resources = $this->parseResources($resources->getResources());
                $_resources[] = $resourceParser->parse($resources);

                return $_resources;
            } else {

                return $resourceParser->parse($resources);
            }
        }
    }
}