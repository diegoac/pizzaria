<?php
// $Id$

require_once 'simple_include.php';
require_once 'pager_include.php';

class PagerJumpingTests extends GroupTest {
    function PagerJumpingTests() {
        $this->GroupTest('Pager_Jumping Tests');
        $this->addTestFile('pager_jumping_test.php');
        $this->addTestFile('pager_jumping_noData_test.php');
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = new PagerTests();
    $test->run(new HtmlReporter());
}
?>