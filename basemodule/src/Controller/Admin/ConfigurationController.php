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

namespace PrestaShop\Module\BaseModule\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ConfigurationController extends FrameworkBundleAdminController
{
    public function index(Request $request): Response
    {
        $dataHandler = $this->get('prestashop.module.basemodule.form.configuration.data_handler');

        $form = $dataHandler->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $dataHandler->save($form->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

                return $this->redirectToRoute('base_module_configuration');
            }

            $this->flashErrors($errors);
        }

        return $this->render('@Modules/basemodule/views/templates/admin/configuration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
