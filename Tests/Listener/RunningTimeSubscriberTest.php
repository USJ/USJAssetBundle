<?php 
namespace MDB\AssetBundle\Tests\Listener;

use MDB\AssetBundle\Listener\RunningTimeSubscriber;

/**
 * - create a preupdate event args parameter mock for testing
 */
//TODO: have to rewrite this test case.
class RunningTimeSubscriberTest extends \PHPUnit_Framework_TestCase
{
    const CLASSMETA = "mockclassmeta";
    const OLD_VALUE = "oldvalue";
    protected $options;
    /**
     * Main test running function 
     */
    public function testStartRunningTime()
    {
        $this->options['getRunningTime'] = 0;
        $this->options['getStatusChangedAt'] = 10000;
        $this->options['setRunningTime'] = 10000;

        $runningTimeSubscriber = new RunningTimeSubscriber();
        $runningTimeSubscriber->setContainer($this->getContainerMock());

    }

    private function getDocumentMock()
    {
        $options = $this->options;
        //create document
        $documentMock = $this->getMockBuilder('MDB\AssetBundle\Document\Asset')
            ->disableOriginalConstructor()
            ->setMethods(array('getRunningTime','setRunningTime','getStatusChangedAt'))
            ->getMock();

        //might change
        $documentMock->expects($this->any())
            ->method('getRunningTime')
            ->will($this->returnValue($options['getRunningTime']));

        $documentMock->expects($this->any())
            ->method('getStatusChangedAt')
            ->will($this->returnValue($options['getStatusChangedAt']));

        $documentMock->expects($this->any())
            ->method('setRunningTime')
            ->with($this->greaterThanOrEqual($options['setRunningTime']));

        return $documentMock;
    }

    private function getEventArgsMock()
    {
        $eventArgsMock = $this->getMockBuilder('Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs')
            ->disableOriginalConstructor()
            ->setMethods(array('hasChangedField','getOldValue','getDocument','getDocumentManager'))
            ->getMock();

        $eventArgsMock->expects($this->any())
            ->method('hasChangedField')
            ->with($this->equalTo('status'))
            ->will($this->returnValue(true));

        $eventArgsMock->expects($this->any())
            ->method('getDocument')
            ->will($this->returnValue($this->getDocumentMock()));

        return $eventArgsMock;
    }
    /**
     * Method for creating the mock document manager
     */
    private function getDocumentManagerMock()
    {

        $dmMock = $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getClassMetadata','getUnitOfWork','getRepository'))
            ->getMock();

        $dmMock->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo('MDB\AssetBundle\Document\Asset'))
            ->will($this->returnValue(self::CLASSMETA));

        $dmMock->expects($this->any())
            ->method('getUnitOfWork')
            ->will($this->returnValue($this->getUOWMock()));

        // create status mock
        $dmMock->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo('MDBAssetBundle:Status'))
            ->will($this->returnValue($this->getStatusRepositoryMock()));

        return $managerMock;
    }

    private function getStatusMock()
    {
        $statusMock = $this->getMockBuilder('MDB\AssetBundle\Document\Status')
            ->disableOriginalConstructor()
            ->setMethods('getCountedAsRunning')
            ->getMock();

        $statusMock->expects($this->once())
            ->method('getCountedAsRunning')
            ->will($this->returnValue(true));

        return $statusMock;
    }

    private function getStatusRepositoryMock()
    {
        $statusRepoMock = $this->getMockBuilder('MDB\AssetBundle\Repository\AssetRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('findOneById'))
            ->getMock();

        $statusRepoMock->expects($this->once())
            ->method('findOneById')
            ->with($this->equalTo(self::OLD_VALUE))
            ->will($this->returnValue($this->getStatusMock()));
        return $statusRepoMock;
    }

    private function getUOWMock()
    {
        $uowMock = $this->getMockBuilder('Doctrine\ODM\MongoD\UnitOfWork')
            ->disableOriginalConstructor()
            ->setMethods(array('recomputeSingleDocumentChangeSet'))
            ->getMock();
        $uowMock->expects($this->once())
            ->method('recomputeSingleDocumentChangeSet')
            ->with($this->equalTo(self::CLASSMETA), $this->equalTo($this->getDocumentMock())); 

        return $uowMock;
    }

    /**
     * Method for creating mock container
     */
    private function getContainerMock()
    {
        $containerMock = $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')
            ->setMethods(array('get', 'setContainer'))
            ->disableOriginalConstructor()
            ->getMock();

        $containerMock->expects($this->any())
            ->method('get')
            ->with($this->equalTo('doctrine_mongodb'))
            ->will($this->returnValue($this->getDocumentManagerMock()));

        return $containerMock;
    }

}