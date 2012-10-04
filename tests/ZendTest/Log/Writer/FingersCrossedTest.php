<?php
/**
 * Zend Framework (http://framework.zend.com/)
*
* @link      http://github.com/zendframework/zf2 for the canonical source repository
* @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
* @license   http://framework.zend.com/license/new-bsd New BSD License
* @package   Zend_Log
*/

namespace ZendTest\Log\Writer;

use Zend\Log\Writer\FingersCrossed as FingersCrossedWriter;
use Zend\Log\Writer\Mock as MockWriter;
use Zend\Log\Logger;

/**
 * @category   Zend
 * @package    Zend_Log
 * @subpackage UnitTests
 * @group      Zend_Log
 */
class FingersCrossedTest extends \PHPUnit_Framework_TestCase
{
    public function testBuffering()
    {
        $wrappedWriter = new MockWriter();
        $writer = new FingersCrossedWriter($wrappedWriter, 2);

        $writer->write(array('priority' => 3, 'message' => 'foo'));

        $this->assertSame(count($wrappedWriter->events), 0);
    }

    public function testFlushing()
    {
        $wrappedWriter = new MockWriter();
        $writer = new FingersCrossedWriter($wrappedWriter, 2);

        $writer->write(array('priority' => 3, 'message' => 'foo'));
        $writer->write(array('priority' => 1, 'message' => 'bar'));

        $this->assertSame(count($wrappedWriter->events), 2);
    }

    public function testAfterFlushing()
    {
        $wrappedWriter = new MockWriter();
        $writer = new FingersCrossedWriter($wrappedWriter, 2);

        $writer->write(array('priority' => 3, 'message' => 'foo'));
        $writer->write(array('priority' => 1, 'message' => 'bar'));
        $writer->write(array('priority' => 3, 'message' => 'bar'));

        $this->assertSame(count($wrappedWriter->events), 3);
    }
}