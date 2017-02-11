<?php
/**
 * @package   Gantry5
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2016 RocketTheme, LLC
 * @license   Dual License: MIT or GNU/GPLv2 and later
 *
 * http://opensource.org/licenses/MIT
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Gantry Framework code that extends GPL code is considered GNU/GPLv2 and later
 */

namespace Gantry\Admin\Controller\Html;

use Gantry\Component\Config\ConfigFileFinder;
use Gantry\Component\Controller\HtmlController;
use Gantry\Component\Request\Request;
use Gantry\Component\Response\HtmlResponse;
use Gantry\Component\Response\JsonResponse;
use Gantry\Component\Response\Response;
use Gantry\Component\Layout\Layout as LayoutObject;
use Gantry\Framework\Outlines as OutlinesObject;
use RocketTheme\Toolbox\ResourceLocator\UniformResourceLocator;

class Configurations extends HtmlController
{
    protected $httpVerbs = [
        'GET' => [
            '/'   => 'index',
            '/**' => 'forward',
        ],
        'POST' => [
            '/'                => 'undefined',
            '/*'               => 'undefined',
            '/create'          => 'createForm',
            '/create/new'      => 'create',
            '/*/rename'        => 'rename',
            '/*/duplicate'     => 'duplicateForm',
            '/*/duplicate/new' => 'duplicate',
            '/*/delete'        => 'delete',
            '/*/**'            => 'forward',
        ],
        'PUT'    => [
            '/'   => 'undefined',
            '/**' => 'forward'
        ],
        'PATCH'  => [
            '/'   => 'undefined',
            '/**' => 'forward'
        ]
    ];

    public function index()
    {
        /** @var UniformResourceLocator $locator */
        $locator = $this->container['locator'];

        $finder = new ConfigFileFinder;
        $files = $finder->getFiles($locator->findResources('gantry-layouts://'));
        $layouts = array_keys($files);
        sort($layouts);

        $layouts_user = array_filter($layouts, function($val) { return strpos($val, 'presets/') !== 0 && substr($val, 0, 1) !== '_'; });
        $layouts_core = array_filter($layouts, function($val) { return strpos($val, 'presets/') !== 0 && substr($val, 0, 1) === '_'; });
        $this->params['layouts'] = ['user' => $layouts_user, 'core' => $layouts_core];

        return $this->container['admin.theme']->render('@gantry-admin/pages/configurations/configurations.html.twig', $this->params);
    }

    public function createForm()
    {
        if (!$this->container->authorize('outline.create')) {
            $this->forbidden();
        }

        $params = [
            'presets' => LayoutObject::presets()
        ];

        $response = ['html' => $this->container['admin.theme']->render('@gantry-admin/ajax/outline-new.html.twig', $params)];

        return new JsonResponse($response);
    }

    public function create()
    {
        if (!$this->container->authorize('outline.create')) {
            $this->forbidden();
        }

        /** @var OutlinesObject $configurations */
        $configurations = $this->container['configurations'];

        $title = $this->request->post->get('title', 'Untitled');
        $preset = $this->request->post->get('preset', 'default');

        $id = $configurations->create($title, $preset);

        $html = $this->container['admin.theme']->render(
            '@gantry-admin/layouts/outline.html.twig',
            ['name' => $id, 'title' => $title]
        );

        return new JsonResponse(['html' => 'Outline created.', 'id' => "outline-{$id}", 'outline' => $html]);
    }

    public function rename($configuration)
    {
        if (!$this->container->authorize('outline.rename')) {
            $this->forbidden();
        }

        /** @var OutlinesObject $configurations */
        $configurations = $this->container['configurations'];
        $list = $configurations->user();

        if (!isset($list[$configuration])) {
            $this->forbidden();
        }

        $title = $this->request->post['title'];
        $id = $configurations->rename($configuration, $title);

        $html = $this->container['admin.theme']->render(
            '@gantry-admin/layouts/outline.html.twig',
            ['name' => $id, 'title' => $title]
        );

        return new JsonResponse(['html' => 'Outline renamed.', 'id' => "outline-{$configuration}", 'outline' => $html]);
    }

    public function duplicateForm($configuration)
    {
        if (!$this->container->authorize('outline.create')) {
            $this->forbidden();
        }

        /** @var OutlinesObject $configurations */
        $configurations = $this->container['configurations'];
        $preset = $configurations->preset($configuration);

        $params = [
            'presets' => LayoutObject::presets(),
            'outline' => $configuration,
            'preset'  => $preset,
            'duplicate' => true
        ];

        $response = ['html' => $this->container['admin.theme']->render('@gantry-admin/ajax/outline-new.html.twig', $params)];

        return new JsonResponse($response);
    }

    public function duplicate($configuration)
    {
        if (!$this->container->authorize('outline.create')) {
            $this->forbidden();
        }

        /** @var OutlinesObject $configurations */
        $configurations = $this->container['configurations'];

        // Handle special case on duplicating a preset.
        if ($configuration && $configuration[0] == '_') {
            $preset = $configurations->preset($configuration);
            $title = ucwords(trim(str_replace('_', ' ', $configuration)));
            if (empty($preset)) {
                throw new \RuntimeException('Preset not found', 404);
            }

            $id = $configurations->create($title, $configuration);
            $html = $this->container['admin.theme']->render(
                '@gantry-admin/layouts/outline.html.twig',
                ['name' => $id, 'title' => $title]
            );

            return new JsonResponse(['html' => 'System configuration duplicated.', 'id' => $id, 'outline' => $html]);
        }

        $list = $configurations->user();

        if (!isset($list[$configuration]) && $configuration !== 'default') {
            $this->forbidden();
        }

        $id = $configurations->duplicate($configuration, $this->request->post['title']);

        $html = $this->container['admin.theme']->render(
            '@gantry-admin/layouts/outline.html.twig',
            ['name' => $id, 'title' => $configurations[$id]]
        );

        return new JsonResponse(['html' => 'Outline duplicated.', 'id' => $id, 'outline' => $html]);
    }

    public function delete($configuration)
    {
        if (!$this->container->authorize('outline.delete')) {
            $this->forbidden();
        }

        /** @var OutlinesObject $configurations */
        $configurations = $this->container['configurations'];
        $list = $configurations->user();

        if (!isset($list[$configuration])) {
            $this->forbidden();
        }

        $configurations->delete($configuration);

        return new JsonResponse(['html' => 'Outline deleted.', 'outline' => $configuration]);
    }

    public function forward()
    {
        $path = func_get_args();

        $configurations = $this->container['configurations']->toArray();

        $configuration = isset($configurations[$path[0]]) ? array_shift($path) : 'default';

        $this->container['configuration'] = $configuration;

        $method = $this->params['method'];
        $page = (array_shift($path) ?: 'styles');
        $resource = $this->params['location'] . '/'. $page;

        $this->params['configuration'] = $configuration;
        $this->params['location'] = $resource;
        $this->params['configuration_page'] = $page;
        $this->params['navbar'] = !empty($this->request->get['navbar']);

        return $this->executeForward($resource, $method, $path, $this->params);
    }

    protected function executeForward($resource, $method = 'GET', $path, $params = [])
    {
        $class = '\\Gantry\\Admin\\Controller\\Html\\' . strtr(ucwords(strtr($resource, '/', ' ')), ' ', '\\');
        if (!class_exists($class)) {
            throw new \RuntimeException('Outline not found', 404);
        }

        /** @var HtmlController $controller */
        $controller = new $class($this->container);

        // Execute action.
        $response = $controller->execute($method, $path, $params);

        if (!$response instanceof Response) {
            $response = new HtmlResponse($response);
        }

        return $response;
    }
}
