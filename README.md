# Framework
<table border="0">
  <tr>
    <td width="310"><img height="160" width="310"alt="UCSDMath - Mathlink" src="https://github.com/ucsdmath/Testing/blob/master/ucsdmath-logo.png"></td>
    <td><h3>A Development Project in PHP</h3><p><strong>UCSDMath</strong> provides a testing framework for general internal Intranet software applications for the UCSD, Department of Mathematics. This is used for development and testing only. [not for production]</p>

<center>
<table style="width:380px;"><tr>
    <td width="130">Travis CI</td><td width="250">SensioLabs</td>
</tr>
<tr><td width="130"><a href="https://travis-ci.org/ucsdmath/Framework">
<img style="float: left; margin: 0px 0px 15px 15px;" src="https://travis-ci.org/ucsdmath/Framework.svg?branch=master"></a></td>
<td width="250" align="center">
<a href="https://insight.sensiolabs.com/projects/ec2d4526-8fb0-4351-a697-0279dfaeed1c">
<img src="https://insight.sensiolabs.com/projects/ec2d4526-8fb0-4351-a697-0279dfaeed1c/big.png" style="float: right; margin: 0px 0px 15px 15px;" width="212" height="51"></a></td>
</tr></table>
</center>
</td></tr></table>

|Scrutinizer|Latest|PHP|Usage|Develop|Code Quality|License|
|-----------|------|---|-----|-------|------------|-------|
|[![Build Status](https://scrutinizer-ci.com/g/ucsdmath/Framework/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ucsdmath/Framework/build-status/master)|[![Latest Stable Version](https://poser.pugx.org/ucsdmath/Framework/v/stable)](https://packagist.org/packages/ucsdmath/Framework)|[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg)](https://php.net/)|[![Total Downloads](https://poser.pugx.org/ucsdmath/Framework/downloads)](https://packagist.org/packages/ucsdmath/Framework)|[![Latest Unstable Version](https://poser.pugx.org/ucsdmath/Framework/v/unstable)](https://packagist.org/packages/ucsdmath/Framework)|[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ucsdmath/Framework/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ucsdmath/Framework/?branch=master)|[![License](https://poser.pugx.org/ucsdmath/Framework/license)](https://packagist.org/packages/ucsdmath/Framework)|

Framework is a testing and development library only. This is not to be used in a production.
Many features of this component have not been developed but are planned for future implementation.  UCSDMath components are written to be adapters of great developments such as Symfony, Twig, Doctrine, etc. This is a learning and experimental library only.

Copy this software from:
- [Packagist.org](https://packagist.org/packages/ucsdmath/Framework)
- [Github.com](https://github.com/ucsdmath/Framework)

## Installation using [Composer](http://getcomposer.org/)
You can install the class ```Framework``` with Composer and Packagist by
adding the ucsdmath/framework package to your composer.json file:

```
"require": {
    "php": "^7.0",
    "ucsdmath/framework": "dev-master"
},
```
Or you can add the class directly from the terminal prompt:

```bash
$ composer require ucsdmath/framework
```

## Usage

``` php
$app = new \UCSDMath\Framework\Framework();
```

## Documentation

No documentation site available at this time.
<!-- [Check out the documentation](http://math.ucsd.edu/~deisner/documentation/Framework/) -->

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email deisner@ucsd.edu instead of using the issue tracker.

## Credits

- [Daryl Eisner](https://github.com/UCSDMath)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
