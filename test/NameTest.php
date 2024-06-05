<?php

declare(strict_types=1);

namespace Vokativ\Test;

use PHPUnit\Framework\TestCase;
use Vokativ\Name;

define(
    'VOKATIV_TEST_DIR',
    __DIR__ . DIRECTORY_SEPARATOR .'data' . DIRECTORY_SEPARATOR
);

final class NameTest extends TestCase
{
    protected $_vokativ;

    protected function loadTests($name)
    {
        $filename = VOKATIV_TEST_DIR . $name . '.txt';

        $f = fopen($filename, 'r');

        $tests = [];

        do {
            $line = fgets($f);
            if ($line === false) {
                break;
            }

            $trimmedLine = rtrim($line);

            if (mb_strlen($trimmedLine) > 0) {
                $tests[] = explode(' ', $trimmedLine, 2);
            }
        } while (1);

        fclose($f);
        return $tests;
    }

    public function setUp(): void
    {
        $this->_vokativ = new Name();
    }

    public function testBasics(): void
    {
        $this->assertTrue($this->_vokativ->isMale('Tom'));
        $this->assertEquals('tome', $this->_vokativ->vokativ('Tom'));
        $this->assertEquals('tome', $this->_vokativ->vokativ('toM'));
        $this->assertEquals('tome', $this->_vokativ->vokativ('ToM'));
    }

    public function testManFirstNames()
    {
        foreach (
            $this->loadTests('man_first_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, $this->_vokativ->vokativ($name, false, false));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, null, false));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, false));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name));
            $this->assertTrue($this->_vokativ->isMale($name));
        }
    }

    public function testManLastNames()
    {
        foreach (
            $this->loadTests('man_last_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, $this->_vokativ->vokativ($name, false, true));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, null, true));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, false));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name));
            $this->assertTrue($this->_vokativ->isMale($name));
        }
    }

    public function testWomanFirstNames()
    {
        foreach (
            $this->loadTests('woman_first_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, $this->_vokativ->vokativ($name, true, false));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, null, false));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, true));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name));
            $this->assertFalse($this->_vokativ->isMale($name));
        }
    }

    public function testWomanLastNames()
    {
        foreach (
            $this->loadTests('woman_last_name_tests') as list($name, $vok)) {

            $this->assertEquals($vok, $this->_vokativ->vokativ($name, true, true));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, null, true));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name, true));
            $this->assertEquals($vok, $this->_vokativ->vokativ($name));
            $this->assertFalse($this->_vokativ->isMale($name));
        }
    }
}