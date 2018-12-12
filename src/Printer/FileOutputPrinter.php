<?php

namespace Vanare\BehatCucumberJsonFormatter\Printer;

use Behat\Testwork\Output\Exception\BadOutputPathException;
use Behat\Testwork\Output\Printer\OutputPrinter as OutputPrinterInterface;

class FileOutputPrinter implements OutputPrinterInterface
{
    const FILE_SEPARATOR = '-';

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $fileNamePrefix;

    /**
     * @var string
     */
    private $resultFileName = '';

    /**
     * @param $fileNamePrefix
     * @param $path
     */
    public function __construct($fileNamePrefix, $path)
    {
        $this->fileNamePrefix = $fileNamePrefix;
        $this->setOutputPath($path);
    }

    /**
     * Sets output path.
     *
     * @param string $path
     */
    public function setOutputPath($path)
    {
        if (!file_exists($path)) {
            if (!mkdir($path, 0755, true)) {
                throw new BadOutputPathException(
                    sprintf(
                        'Output path %s does not exist and could not be created!',
                        $path
                    ),
                    $path
                );
            }
        } else {
            if (!is_dir($path)) {
                throw new BadOutputPathException(
                    sprintf(
                        'The argument to `output` is expected to the a directory, but got %s!',
                        $path
                    ),
                    $path
                );
            }
        }
        $this->path = $path;
    }

    /**
     * @param string $resultFileName
     */
    public function setResultFileName($resultFileName)
    {
        $this->resultFileName = $resultFileName;
    }

    /**
     * @return string
     */
    public function getResultFileName()
    {
      return $this->resultFileName;
    }

    /** @inheritdoc */
    public function getOutputPath()
    {
        return $this->path;
    }

    /** @inheritdoc */
    public function setOutputStyles(array $styles)
    {
    }

    /** @inheritdoc */
    public function getOutputStyles()
    {
        return [];
    }

    /** @inheritdoc */
    public function setOutputDecorated($decorated)
    {
    }

    /** @inheritdoc */
    public function isOutputDecorated()
    {
        return null;
    }

    /** @inheritdoc */
    public function setOutputVerbosity($level)
    {
    }

    /** @inheritdoc */
    public function getOutputVerbosity()
    {
        return 0;
    }

    /** @inheritdoc */
    public function write($messages, $append = false)
    {
        $file = $this->getOutputPath() . DIRECTORY_SEPARATOR . $this->fileNamePrefix . $this->resultFileName . '.json';

        if ($append) {
            file_put_contents($file, $messages, FILE_APPEND);
        } else {
            file_put_contents($file, $messages);
        }
    }

    /** @inheritdoc */
    public function writeln($messages = '')
    {
        $this->write($messages, true);
    }

    /** @inheritdoc */
    public function flush()
    {
    }
}
