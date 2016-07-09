<?php

declare (strict_types = 1);

namespace TwitterKeywordFrequency\CLI;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TwitterKeywordFrequencyCommand extends Command
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this
            ->setName('twitter:keyword:frequency')
            ->setDescription('Reads frequency of keywords in last 100 tweets from a given account')
            ->addArgument('account', InputArgument::REQUIRED);
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $account = $input->getArgument('account');

        $output->writeln(sprintf('Account "%s"', $account));
    }
}
