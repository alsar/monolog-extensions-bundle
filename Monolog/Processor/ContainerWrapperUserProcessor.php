<?php
namespace Alsar\MonologExtensionsBundle\Monolog\Processor;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Alsar\Monolog\Processor\UserProcessor;

class ContainerWrapperUserProcessor
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $record
     *
     * @return string
     */
    public function processRecord(array $record)
    {
        $securityContext = $this->container->get('security.context');

        return (new UserProcessor($securityContext))->processRecord($record);
    }
}