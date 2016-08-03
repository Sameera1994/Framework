# Framework
<table border="0">
  <tr>
    <td width="310"><img height="160" width="310"alt="UCSDMath - Mathlink" src="https://github.com/ucsdmath/Testing/blob/master/ucsdmath-logo.png"></td>
    <td><h3>A Development Project in PHP</h3><p><strong>UCSDMath</strong> provides a testing framework for general internal Intranet software applications for the UCSD, Department of Mathematics. This is used for development and testing only. [not for production]</p>

<table width="550"><tr><td width="120"><b>Travis CI</b></td><td width="250"><b>SensioLabs</b></td><td width="180"><b>Dependencies</b></td></tr><tr>
    <td width="120" align="center">
        <a href="https://travis-ci.org/ucsdmath/Framework">
        <img src="https://travis-ci.org/ucsdmath/Framework.svg?branch=master" style="float: left; margin: 0px 0px 10px 10px;"></a><br>
        <a href="https://www.codacy.com/app/ucsdmath-project/Framework">
        <img src="https://api.codacy.com/project/badge/Grade/103c2b2b425344ccacbbe7c5094768d9"></a></td>
    <td width="250" align="center">
        <a href="https://insight.sensiolabs.com/projects/a55d300b-4f1c-40f1-9b7b-08c891f4d7c2">
        <img src="https://insight.sensiolabs.com/projects/a55d300b-4f1c-40f1-9b7b-08c891f4d7c2/big.png" style="float: right; margin: 0px 0px 10px 10px;" width="212" height="51"></a></td>
    <td width="180" align="center">
        <a href="https://www.versioneye.com/user/projects/577fba2e5bb1390040177ba8">
        <img src="https://www.versioneye.com/user/projects/577fba2e5bb1390040177ba8/badge.png?style=flat" style="float:left;margin:0px 0px 10px 10px;"></a><br>
        <a href="https://codeclimate.com/github/ucsdmath/Framework">
        <img src="https://codeclimate.com/github/ucsdmath/Framework/badges/gpa.svg"></a><br>
        <a href="https://travis-ci.org/ucsdmath/Framework">
        <img src="http://php7ready.timesplinter.ch/ucsdmath/Framework/badge.svg"></a>
</td></tr></table></td></tr></table>
<table width="880"><tr><td width="116" align="center"><b>Scrutinizer</b></td><td width="112" align="center"><b>Latest</b></td><td width="108" align="center"><b>PHP</b></td><td width="150" align="center"><b>Usage</b></td><td width="142" align="center"><b>Development</b></td><td width="142" align="center"><b>Code Quality</b></td><td width="110" align="center"><b>License</b></td></tr><tr>
    <td valign="top" width="116" align="center">
        <a href="https://scrutinizer-ci.com/g/ucsdmath/Framework/build-status/master">
        <img src="https://scrutinizer-ci.com/g/ucsdmath/Framework/badges/build.png?b=master"></a></td>
    <td valign="top" width="112" align="center">
        <a href="https://packagist.org/packages/ucsdmath/Framework">
        <img src="https://poser.pugx.org/ucsdmath/Framework/v/stable"></a></td>
    <td valign="top" width="108" align="center">
        <a href="https://php.net/">
        <img src="https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg"></a></td>
    <td valign="top" width="150" align="center">
        <a href="https://packagist.org/packages/ucsdmath/Framework">
        <img src="https://poser.pugx.org/ucsdmath/Framework/downloads"></a></td>
    <td valign="top" width="142" align="center">
        <a href="https://packagist.org/packages/ucsdmath/Framework">
        <img src="https://poser.pugx.org/ucsdmath/Framework/v/unstable"></a></td>
    <td valign="top" width="142" align="center">
        <a href="https://scrutinizer-ci.com/g/ucsdmath/Framework/?branch=master">
        <img src="https://scrutinizer-ci.com/g/ucsdmath/Framework/badges/quality-score.png?b=master"></a></td>
    <td valign="top" width="110" align="center">
        <a href="https://packagist.org/packages/ucsdmath/Framework">
        <img src="https://poser.pugx.org/ucsdmath/Framework/license"></a></td>
</tr></table>

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
