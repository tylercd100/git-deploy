# Git Deploy
[![Latest Version](https://img.shields.io/github/release/tylercd100/git-deploy.svg?style=flat-square)](https://github.com/tylercd100/git-deploy/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/tylercd100/git-deploy.svg?branch=master)](https://travis-ci.org/tylercd100/git-deploy)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tylercd100/git-deploy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/git-deploy/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/tylercd100/git-deploy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/tylercd100/git-deploy/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56f3252c35630e0029db0187)
[![Total Downloads](https://img.shields.io/packagist/dt/tylercd100/git-deploy.svg?style=flat-square)](https://packagist.org/packages/tylercd100/git-deploy)

Can deploy your git project by executing a git pull

## Installation

Install via [composer](https://getcomposer.org/) - In the terminal:
```bash
composer require tylercd100/git-deploy
```

## Usage

```php
// This is just an example
$deploy = new Deploy('/var/www/foobar.com');

$deploy->post_deploy = function() use ($deploy) {
    // hit the wp-admin page to update any db changes
    exec('curl http://www.foobar.com/wp-admin/upgrade.php?step=upgrade_db');
    $deploy->log('Updating wordpress database... ');
};

$deploy->execute();

```
