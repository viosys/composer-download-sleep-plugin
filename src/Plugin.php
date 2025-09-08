<?php
declare(strict_types=1);

namespace Vio\ComposerDownloadSleep;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PreFileDownloadEvent;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    private ?Config $config = null;
    private ?IOInterface $io = null;

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PluginEvents::PRE_FILE_DOWNLOAD => array(
                array('onPreFileDownload', 0)
            )
        ];
    }

    public function activate(Composer $composer, IOInterface $io): void
    {
        $extra = $composer->getPackage()->getExtra();
        $this->io = $io;

        // Extract your plugin's configuration
        $configData = $extra['viosys/composer-download-sleep-plugin'] ?? [];

        $config = new Config();
        if(array_key_exists('duration', $configData)) {
            if(is_numeric($configData['duration'])) {
                $duration = (int)$configData['duration'];
                if($duration > 0) {
                    $config->duration = $duration;
                }
                else {
                    $io->writeError(sprintf('<error>Invalid duration "%s" for vio/composer-download-sleep-plugin, expected a positive number</error>', $configData['duration']));
                }
            }
            else {
                $io->writeError(sprintf('<error>Invalid duration "%s" for vio/composer-download-sleep-plugin, expected a number</error>', $configData['duration']));
            }
        }
        if(array_key_exists('urlsToApply', $configData)) {
            if(!is_array($configData['urlsToApply'])) {
                $io->writeError(sprintf('<error>Invalid urlsToApply "%s" for vio/composer-download-sleep-plugin, expected an array</error>', $configData['urlsToApply']));
            }
            $config->urlsToApply = $configData['urlsToApply'];
        } else {
            $io->writeError('<warning>No urlsToApply configured, the usage of this plugin makes no sense!</warning>');
        }
        // Set default values if needed
        $this->config = $config;
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }


    public function onPreFileDownload(PreFileDownloadEvent $event): void
    {
        if(empty($this->config->urlsToApply)) {
            return;
        }
        if(!in_array(true, array_map(static fn(string $url) => str_starts_with($event->getProcessedUrl(), $url), $this->config->urlsToApply), true)) {
            return;
        }
        if ( $this->io?->isVerbose()) {
            $this->io->write(sprintf('<info>Sleeping for %d seconds for %s</info>', $this->config->duration, $event->getProcessedUrl()));
        }
        sleep($this->config->duration);

    }
}