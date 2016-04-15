<?php

namespace Tylercd100\GitDeploy;

use Exception;
use Monolog\Logger;

class Deploy {

    /**
     * A Monolog Logger
     * 
     * @var Logger
     */
    protected $log;

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
     * @param string      $directory The directory where your website and git repository are located
     * @param string      $branch    The branch to pull
     * @param string      $remote    The remote to use
     * @param Logger|null $log       The Monolog Logger instance to use
     */
    public function __construct($directory, $branch = 'master', $remote = 'origin', Logger $log = null)
    {
        // Determine the directory path
        $this->directory = realpath($directory).DIRECTORY_SEPARATOR;

        // Logger
        if(!$log instanceof Logger)
        {
            $log = new Logger('Deployment');
        }
        $this->log = $log;

        $this->log->info('Attempting deployment...');
    }

    /**
     * Executes the necessary commands to deploy the website.
     */
    public function execute()
    {
        try
        {
            // Make sure we're in the right directory
            exec('cd '.$this->directory, $output);
            $this->log->info('Changing working directory... '.implode(' ', $output));

            // Discard any changes to tracked files since our last deploy
            exec('git reset --hard HEAD', $output);
            $this->log->info('Reseting repository... '.implode(' ', $output));

            // Update the local repository
            exec('git pull '.$this->remote.' '.$this->branch, $output);
            $this->log->info('Pulling in changes... '.implode(' ', $output));

            // Secure the .git directory
            exec('chmod -R og-rx .git');
            $this->log->info('Securing .git directory... ');

            $this->log->info('Deployment successful.');
        }
        catch (Exception $e)
        {
            $this->log->error($e);
        }
    }
}
