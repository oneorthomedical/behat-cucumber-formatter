<?php

namespace Vanare\BehatCucumberJsonFormatter\Formatter;

use Behat\Testwork\Output\Formatter as FormatterOutputInterface;
use Vanare\BehatCucumberJsonFormatter\Node\Suite;

interface FormatterInterface extends FormatterOutputInterface
{
    /**
     * Returns all executed suites.
     *
     * @return Suite[]
     */
    public function getSuites();
}
