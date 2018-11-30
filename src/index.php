<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/12/21
 * Time: 18:05
 */

include 'Blog.php';
include 'Parsedown.php';

define('ROOTPATH', realpath(__DIR__.'/../'));
define('NOTEPATH', ROOTPATH.'/source/');
define('BLOGPATH', ROOTPATH.'/blog/');
define('TPLPATH', ROOTPATH.'/template/');

$blog = new Blog(new Parsedown());

$blog->generator();