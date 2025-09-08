<?php
declare(strict_types=1);

namespace Vio\ComposerDownloadSleep;

class Config
{

    public int $duration = 1;

    /** @var string[] */
    public array $urlsToApply = [];
}