<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT Free License
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/license/mit
 *
 * @author    Andrei H
 * @copyright Since 2024 Andrei H
 * @license   MIT
 */

declare(strict_types=1);

namespace PrestaShop\Module\BaseModule\Form\Configuration;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

final class DataConfiguration implements DataConfigurationInterface
{
    private const SIMPLE_TEXT_INPUT = 'SIMPLE_TEXT_INPUT';
    private const SIMPLE_TEXT_INPUT_MAXLENGTH = 32;

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    /**
     * ConfigurationFormDataConfiguration constructor.
     *
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): array
    {
        $return = [];

        $return['config_text'] = $this->configuration->get(static::SIMPLE_TEXT_INPUT);

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            if (strlen($configuration['config_text']) <= static::SIMPLE_TEXT_INPUT_MAXLENGTH) {
                $this->configuration->set(static::SIMPLE_TEXT_INPUT, $configuration['config_text']);
            } else {
                $errors[] = 'Configuration text value is too long';
            }
        }

        /* Errors are returned here. */
        return $errors;
    }

    /**
     * {@inheritdoc}
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['config_text']);
    }
}
