<?php

namespace Tylercd100\GitDeploy;

use Exception;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Deploy implements LoggerAwareInterface{

    use LoggerAwareTrait;

    /**
     * The name of the branch to pull from.
     * 
     * @var string
     */
    protected $branch = 'master';

    /**
     * The name of the remote to pull from.
     * 
     * @var string
     */
    protected $remote = 'origin';

    /**
     * The directory where your website and git repository are located, can be 
     * a relative or absolute path
     * 
     * @var string
     */
    protected $directory;

    /**
     * @param string               $directory The directory where your website and git repository are located
     * @param string               $branch The branch to pull
     * @param string               $remote The remote to use
     * @param LoggerInterface|null $logger The LoggerInterface instance to use
     */
    public function __construct($directory, $branch = 'master', $remote = 'origin', LoggerInterface $logger = null)
    {
        // LoggerInterface
        if(!$logger instanceof LoggerInterface)
        {
            $logger = new Logger('Deployment');
        }
        $this->setLogger($logger);

        //Properties
        $this->directory = realpath($directory).DIRECTORY_SEPARATOR;
        $this->branch = $branch;
        $this->remote = $remote;
    }

    /**
     * Executes the necessary commands to deploy the website.
     */
    public function execute()
    {
        $this->logger->debug('Attempting deployment...');

        try
        {
            // Make sure we're in the right directory
            exec('cd '.$this->directory, $output);
            $this->logger->debug('Changing working directory... '.implode(' ', $output));

            // Discard any changes to tracked files since our last deploy
            exec('git reset --hard HEAD', $output);
            $this->logger->debug('Reseting repository... '.implode(' ', $output));

            // Update the local repository
            exec('git pull '.$this->remote.' '.$this->branch, $output);
            $this->logger->debug('Pulling in changes... '.implode(' ', $output));

            // Secure the .git directory
            exec('chmod -R og-rx .git');
            $this->logger->debug('Securing .git directory... ');

            $this->logger->notice('Deployment successful.');
        }
        catch (Exception $e)
        {
            $this->logger->error($e);
        }
    }
}
