# Behat Cucumber Json Formatter 

*Note*: this is a fork of [Vanare/behat-cucumber-formatter](https://github.com/Vanare/behat-cucumber-formatter). As the original project seems unmaintained and there is no possibility to contact the owner, I publish the library under my handle. Many thanks to the original team of Vanare for starting this great library!

This is Behat extension for generating json reports for [Cucumber Test Result Plugin](https://github.com/jenkinsci/cucumber-testresult-plugin/) which provides graphs over time and drill down to individual results using the standard Jenkins test reporting mechanism.

## Requirements

- PHP 5.5.x or higher

- Behat 3.x

## Installation

### Installation via Composer:

```
$ composer require --dev cawolf/behat-cucumber-json-formatter
```

## Usage

Setup extension by specifying your `behat.yml`:

```
default:
    extensions:
        Vanare\BehatCucumberJsonFormatter\Extension:
            fileNamePrefix: report
            outputDir: %paths.base%/build/tests
```

Then you can run:

```
bin/behat -f cucumber_json
```

### Available options:

- `fileNamePrefix`: Filename prefix of generated report
- `outputDir`: Generated report will be placed in this directory

## Licence

MIT Licence