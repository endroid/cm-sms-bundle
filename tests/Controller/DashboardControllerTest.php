<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Tests;

use Endroid\BundleTest\BundleTestCase;

class DashboardControllerTest extends BundleTestCase
{
    public function testDashboardController()
    {
        $client = static::createClient();
        $client->request('GET', '/cm-sms/message/send/0000000000');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}