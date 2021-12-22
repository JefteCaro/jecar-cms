<?php

use Jecar\Cms\Services\CmsService;
use PHPUnit\Framework\TestCase;

class CmsServiceTest extends TestCase
{
    public function testInstance()
    {
        $obj = new CmsService();
        $this->assertInstanceOf(CmsService::class, $obj);
    }
}