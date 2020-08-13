#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/21
 * Time: 18:05
 */

$basePath = realpath(__DIR__.'/../') . '/';

include $basePath . 'src/Blog.php';
include $basePath . 'src/Parsedown.php';

$blog = new Blog(
    new Parsedown()
);

$blog->basePath = $basePath;
$blog->tplPath = $basePath . 'tpl/';
$blog->distPath = $basePath . 'dist/';
$blog->sourcePath = $basePath . 'source/';

$blog->generator();