<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\DependencyInjection;

use Endroid\CmSms\Client;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class EndroidCmSmsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $clientDefinition = $container->getDefinition(Client::class);
        $clientDefinition->setArguments([$config['product_token'], $config['defaults'], $config['delivery_phone_numbers'], $config['disable_delivery']]);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $path = __DIR__.'/../Resources/public/build/manifest.json';

        $container->prependExtensionConfig('framework', [
            'assets' => [
                'packages' => [
                    'endroid_cm_sms' => [
                        'json_manifest_path' => realpath($path),
                    ],
                ],
            ],
        ]);
    }
}
