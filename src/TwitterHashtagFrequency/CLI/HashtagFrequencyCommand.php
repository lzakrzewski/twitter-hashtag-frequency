<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\CLI;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TwitterHashtagFrequency\CLI\Renderer\HashtagFrequencyProjectionRenderer;
use TwitterHashtagFrequency\HashtagProvider;
use TwitterHashtagFrequency\Projection\HashtagFrequencyProjection;

class HashtagFrequencyCommand extends Command
{
    /** @var HashtagProvider */
    private $provider;

    public function __construct(HashtagProvider $provider)
    {
        parent::__construct(null);

        $this->provider = $provider;
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this
            ->setName('hashtag:frequency')
            ->setDescription('Reads frequency of hashtags in last 100 tweets from a given screen name')
            ->addArgument('screenName', InputArgument::REQUIRED);
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $screenName = $input->getArgument('screenName');

        try {
            $this->renderer()->render($screenName, $output);
        } catch (\Exception $e) {
            return $this->handleException($e, $output);
        }

        return 0;
    }

    private function handleException(\Exception $exception, OutputInterface $output) : int
    {
        $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

        return 1;
    }

    private function renderer() : HashtagFrequencyProjectionRenderer
    {
        return new HashtagFrequencyProjectionRenderer($this->projection());
    }

    private function projection() : HashtagFrequencyProjection
    {
        return new HashtagFrequencyProjection($this->provider);
    }
}
