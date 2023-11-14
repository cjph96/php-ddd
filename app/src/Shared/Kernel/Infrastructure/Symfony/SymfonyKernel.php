<?php

declare(strict_types=1);

namespace App\Shared\Kernel\Infrastructure\Symfony;

use Generator;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

final class SymfonyKernel extends BaseKernel
{
    use MicroKernelTrait;

    public function __construct(?string $environment = null, ?bool $debug = null)
    {
        self::loadEnvironment($environment);
        parent::__construct(
            $environment ?: $_SERVER['APP_ENV'],
            $debug ?: (bool) $_SERVER['APP_DEBUG'],
        );
    }

    /** Overrides MicroKernelTrait registerBundles method */
    public function registerBundles(): Generator
    {
        foreach (Bundles::getBundles() as $bundle) {
            yield $bundle;
        }
    }

    private static function loadEnvironment(?string $environment): void
    {
        $dotenv = new Dotenv();
        $dotenv->usePutenv();
        $envFile = dirname(__DIR__, 5) .'/.env';
        if (null !== $environment) {
            $envFile .= '.'. $environment;
        }
        $dotenv->loadEnv($envFile);
    }

    /** Overrides MicroKernelTrait configureContainer method */
    private function configureContainer(ContainerConfigurator $container): void
    {
        $configDir = $this->getConfigDir();

        $container->import($configDir.'/{packages}/*.{php,yaml}');
        $container->import($configDir.'/{packages}/'.$this->environment.'/*.{php,yaml}');

        if (is_file($configDir.'/services.yaml')) {
            $container->import($configDir.'/{parameters,services}.yaml');
            $container->import($configDir.'/{parameters,services}_'.$this->environment.'.yaml');
        }
    }

    /** Overrides MicroKernelTrait getConfigDir method */
    private function getConfigDir(): string
    {
        return dirname(__DIR__) .'/Symfony/config';
    }
}
