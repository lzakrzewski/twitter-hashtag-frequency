<?php

declare (strict_types = 1);

namespace TwitterHashtagFrequency\CLI\Renderer;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use TwitterHashtagFrequency\Projection\HashtagFrequencyProjection;

class HashtagFrequencyProjectionRenderer
{
    /** @var HashtagFrequencyProjection */
    private $projection;

    public function __construct(HashtagFrequencyProjection $projection)
    {
        $this->projection = $projection;
    }

    public function render(string $screenName, OutputInterface $output)
    {
        $views = $this->projection->get($screenName);

        $table = new Table($output);
        $table->setHeaders(['keyword', 'count']);

        if (empty($views)) {
            $output->writeln(
                sprintf('<comment>There is no keywords for an screen name "%s"</comment>', $screenName)
            );

            return;
        }

        $output->writeln(
            sprintf(
                'List of most frequently used #hashtags in latest 100 tweets for screen name "%s":',
                $screenName
            )
        );

        foreach ($views as $view) {
            $table->addRow([$view->keyword, $view->count]);
        }

        $table->render();
    }
}
