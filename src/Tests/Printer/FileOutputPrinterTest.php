<?php

namespace Vanare\BehatCucumberJsonFormatter\Tests\Printer;

use Vanare\BehatCucumberJsonFormatter\Printer\FileOutputPrinter;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

class FileOutputPrinterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $validRoot;

    public function setUp()
    {
        $this->validRoot = vfsStream::setup('root', 0775);
    }

    /**
     * @test
     */
    public function setOutputPathExisted()
    {
        $path = $this->validRoot->url();

        $printer = $this->createPrinter($path);

        self::assertEquals($path, $printer->getOutputPath());
    }

    /**
     * @test
     */
    public function setOutputPathNotExisted()
    {
        $path = $this->validRoot->url().'/build_666';

        $printer = $this->createPrinter($path);

        self::assertEquals($path, $printer->getOutputPath());
        self::assertEquals(0755, $this->validRoot->getChild('build_666')->getPermissions());
    }

    /**
     * @test
     *
     * @expectedException \Behat\Testwork\Output\Exception\BadOutputPathException
     */
    public function setOutputPathShouldRaiseExceptionIfPathCanNotBeCreated()
    {
        vfsStream::newDirectory('secured_folder', 0000)->at($this->validRoot);

        $path = $this->validRoot->getChild('secured_folder')->url().'/build_666';

        $this->createPrinter($path);
    }

    /**
     * @test
     *
     * @expectedException \Behat\Testwork\Output\Exception\BadOutputPathException
     */
    public function setOutputPathShouldRaiseExceptionIfPathIsNotADirectory()
    {
        vfsStream::newFile('file.exe', 0755)->at($this->validRoot);

        $path = $this->validRoot->getChild('file.exe')->url();

        $this->createPrinter($path);
    }

    /**
     * @test
     */
    public function write()
    {
        $messages = 'Messages will be here';

        $printer = $this->createPrinter($this->validRoot->url());
        $printer->write($messages);

        /** @var vfsStreamStructureVisitor $visitor */
        $visitor = vfsStream::inspect(new vfsStreamStructureVisitor());
        $expectedStructure = $visitor->getStructure();

        // Assert that string was written
        self::assertEquals(['root' => ['testprefix.json' => $messages]], $expectedStructure);
    }

    /**
     * @test
     */
    public function setResultFileNameAndWriteLn()
    {
        $messages = 'Messages will be here';

        $printer = $this->createPrinter($this->validRoot->url());
        $printer->setResultFileName('agreatsuffix');
        $printer->writeln($messages);

        /** @var vfsStreamStructureVisitor $visitor */
        $visitor = vfsStream::inspect(new vfsStreamStructureVisitor());
        $expectedStructure = $visitor->getStructure();

        // Assert that string was written
        self::assertEquals(['root' => ['testprefixagreatsuffix.json' => $messages]], $expectedStructure);
    }

    /**
     * @test
     */
    public function inheritedUnusedInterface()
    {
        $printer = $this->createPrinter($this->validRoot->url());
        $printer->setOutputStyles([]);
        self::assertEquals([], $printer->getOutputStyles());
        $printer->setOutputDecorated(false);
        self::assertNull($printer->isOutputDecorated());
        $printer->setOutputVerbosity(0);
        self::assertEquals(0, $printer->getOutputVerbosity());
        $printer->flush();
    }

    /**
     * @param $path
     *
     * @return FileOutputPrinter
     */
    protected function createPrinter($path)
    {
        return new FileOutputPrinter('testprefix', $path);
    }
}
