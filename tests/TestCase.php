<?php

if (class_exists('PHPUnit_Framework_TestCase')) {
    class TestCase extends PHPUnit_Framework_TestCase {}
} else {
    class TestCase extends PHPUnit\Framework\TestCase {}
}
