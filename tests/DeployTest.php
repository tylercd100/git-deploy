<?php

namespace Tylercd100\GitDeploy\Tests;

use Tylercd100\GitDeploy\Deploy;

class DeployTest extends TestCase
{
    public function testItCreatesInstanceSuccessfully()
    {
        $obj = new Deploy(__DIR__);
    }
}