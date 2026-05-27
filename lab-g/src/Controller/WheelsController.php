<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Wheels;
use App\Model\Post;
use App\Service\Router;
use App\Service\Templating;

class WheelsController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $wheels = Wheels::findAll();
        $html = $templating->render('wheels/index.html.php', [
            'wheels' => $wheels,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestWheels, Templating $templating, Router $router): ?string
    {
        if ($requestWheels) {
            $wheel = Wheels::fromArray($requestWheels);
            // @todo missing validation
            $wheel->save();

            $path = $router->generatePath('wheels-index');
            $router->redirect($path);
            return null;
        } else {
            $wheel = new Wheels();
        }

        $html = $templating->render('wheels/create.html.php', [
            'wheel' => $wheel,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $wheelsId, ?array $requestWheels, Templating $templating, Router $router): ?string
    {
        $wheel = Wheels::find($wheelsId);
        if (! $wheel) {
            throw new NotFoundException("Missing wheels with id $wheelsId");
        }

        if ($requestWheels) {
            $wheel->fill($requestWheels);
            // @todo missing validation
            $wheel->save();

            $path = $router->generatePath('wheels-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('wheels/edit.html.php', [
            'wheel' => $wheel,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $wheelsId, Templating $templating, Router $router): ?string
    {
        $wheel = Wheels::find($wheelsId);
        if (! $wheel) {
            throw new NotFoundException("Missing wheels with id $wheelsId");
        }

        $html = $templating->render('wheels/show.html.php', [
            'wheel' => $wheel,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $wheelsId, Router $router): ?string
    {
        $wheel = Wheels::find($wheelsId);
        if (! $wheel) {
            throw new NotFoundException("Missing post with id $wheelsId");
        }

        $wheel->delete();
        $path = $router->generatePath('wheels-index');
        $router->redirect($path);
        return null;
    }
}
