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
$autoloader = dirname(__FILE__) . '/vendor/autoload.php';

if (is_readable($autoloader)) {
    include_once $autoloader;
}

if (!defined('_PS_VERSION_')) {
    exit;
}

class BaseModule extends Module
{
    private const HOOKS = [];

    /**
     * BaseModule constructor.
     */
    public function __construct()
    {
        $this->name = 'basemodule';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Andrei H';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '8.0.0',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Base Module', [], 'Modules.Basemodule.Admin');
        $this->description = $this->trans('Base PrestaShop Module.', [], 'Modules.Basemodule.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Basemodule.Admin');
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install()
            && $this->registerHook(self::HOOKS);
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * {@inheritdoc}
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        $route = $this->get('router')->generate('base_module_configuration');
        Tools::redirectAdmin($route);
    }
}
