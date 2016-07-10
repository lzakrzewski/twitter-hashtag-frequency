<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\CLI\Renderer;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use TwitterHashtagFrequency\Application\Projection\TwitterHashtagFrequencyProjection;

class TwitterHashtagFrequencyRenderer
{
    /** @var TwitterHashtagFrequencyProjection */
    private $projection;

    public function __construct(TwitterHashtagFrequencyProjection $projection)
    {
        $this->projection = $projection;
    }

    public function render(string $account, OutputInterface $output)
    {
        $views = $this->projection->get($account);

        $table = new Table($output);
        $table->setHeaders(['keyword', 'count']);

        if (empty($views)) {
            $output->writeln(
                sprintf('<info>There is no keywords for an account "%s"</info>', $account)
            );

            return;
        }

        foreach ($views as $view) {
            $table->addRow([$view->keyword, $view->count]);
        }

        $table->render();
    }
}