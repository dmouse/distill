<?php

namespace Distill\Tests\Method\Extension;

use Distill\Method;
use Distill\Format;
use Distill\Tests\Method\AbstractMethodTest;

class ZipTest extends AbstractMethodTest
{
    public function setUp()
    {
        $this->method = new Method\Extension\Zip();

        if (false === $this->method->isSupported()) {
            $this->markTestSkipped('The zip extension method is not available');
        }

        parent::setUp();
    }

    public function testExtractCorrectZipFile()
    {
        $target = $this->getTemporaryPath();
        $this->clearTemporaryPath();

        $response = $this->extract('file_ok.zip', $target, new Format\Simple\Zip());

        $this->assertTrue($response);
        $this->assertUncompressed($target, 'file_ok.zip');
        $this->clearTemporaryPath();
    }

    public function testExtractFakeZipFile()
    {
        $this->setExpectedException('Distill\\Exception\\IO\\Input\\FileCorruptedException');

        $target = $this->getTemporaryPath();
        $this->clearTemporaryPath();

        $this->extract('file_fake.zip', $target, new Format\Simple\Zip());

        $this->clearTemporaryPath();
    }

    public function testExtractNoZipFile()
    {
        $this->setExpectedException('Distill\\Exception\\Method\\FormatNotSupportedInMethodException');

        $target = $this->getTemporaryPath();
        $this->clearTemporaryPath();

        $this->extract('file_ok.rar', $target, new Format\Simple\Rar());

        $this->clearTemporaryPath();
    }

    public function testExtractCorruptZipFile()
    {
        $this->setExpectedException('Distill\\Exception\\IO\\Input\\FileCorruptedException');

        $target = $this->getTemporaryPath();
        $this->clearTemporaryPath();

        $this->extract('file_corrupt.zip', $target, new Format\Simple\Zip());
    }

    public function testExtractCorrectEpubFile()
    {
        $target = $this->getTemporaryPath();
        $this->clearTemporaryPath();

        $response = $this->extract('file_ok.epub', $target, new Format\Simple\Epub());

        $this->assertTrue($response);
        //$this->checkDirectoryFiles($target, $this->filesPath . '/epub');
        $this->clearTemporaryPath();
    }

    public function testExtractCorrectJarFile()
    {
        $target = $this->getTemporaryPath();
        $this->clearTemporaryPath();

        $response = $this->extract('file_ok.jar', $target, new Format\Simple\Jar());

        $this->assertTrue($response);
        $this->assertUncompressed($target, 'file_ok.jar');
        $this->clearTemporaryPath();
    }
}
