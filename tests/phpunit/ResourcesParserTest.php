<?php
/**
 * Created by PhpStorm.
 * User: dkarpinski
 * Date: 12.05.16
 * Time: 10:07
 */

namespace Madkom\Chimera\Parser\RAML08\Tests;


use Madkom\Chimera\Parser\RAML08\Raml08Parser;
use Madkom\Chimera\Parser\RAML08\ResourcesParser;
use PHPUnit_Framework_TestCase;

/**
 * Class ResourcesParserTest
 * @package Madkom\Chimera\Parser\RAML08\Tests
 */
class ResourcesParserTest extends PHPUnit_Framework_TestCase
{

    private $raml08Parser;

    public function setUp()
    {
        parent::setUp();
        $this->raml08Parser = new Raml08Parser();
    }

    /**
     * @test
     * @group resources
     */
    public function shouldReturnCorrectResources()
    {

        $raml = <<<RAML
#%RAML 0.8
title: ZEncoder API
version: v2
baseUri: https://app.zencoder.com/api/{version}
/Accounts:
   /{AccountSid}:
      post:
        description: Create a Job
        headers:
          Zencoder-Api-Key:
            displayName: ZEncoder API Key
            description: |
              The API key for your Zencoder account. You can find your API key at
              https://app.zencoder.com/api. You can also regenerate your API key on
              that page.
            type: string
            required: true
            minLength: 30
            maxLength: 30
            example: abcdefghijabcdefghijabcdefghij
            pattern: (\+1|1)?([2-9]\d\d[2-9]\d{6}) # E.164 standard
          second-parameter:
            displayName: second parameter
            description: |
              parameter
            type: string
            required: true
            minLength: 0
            maxLength: 30
            example: 123
            pattern: (.*) # E.164 standard
      /Calls:
        post:
          description: |
            Using the Twilio REST API, you can make outgoing calls to phones,
            SIP-enabled endpoints and Twilio Client connections.

            Note that calls initiated via the REST API are rate-limited to one per
            second. You can queue up as many calls as you like as fast as you like,
            but each call is popped off the queue at a rate of one per second.
          body:
            application/x-www-form-urlencoded:
              formParameters:
                From:
                  description: |
                    The phone number or client identifier to use as the caller id. If
                    using a phone number, it must be a Twilio number or a Verified
                    outgoing caller id for your account.
                  type: string
                  required: true
                  pattern: (\+1|1)?([2-9]\d\d[2-9]\d{6}) # E.164 standard
                  example: +14158675309
RAML;
        $definition = $this->raml08Parser->parseFromString($raml);
    }
}