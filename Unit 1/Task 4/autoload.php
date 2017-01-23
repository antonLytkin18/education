<?php
/**
 * @author Maxim Sokolovsky <sokolovsky@worksolutions.ru>
 */
use WS\DataBase\DataBase;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = include __DIR__.'/vendor/autoload.php';
$loader->addPsr4("WS\\", __DIR__."/lib/");
$db = DataBase::getInstance();
$db->setConfig(require_once 'config.php');