<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\RouteMaintenanceMode;
use App\Http\Middleware\StandardizationDocumentsUploadedMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            CheckMaintenanceMode::class,
        ]);
        $middleware->alias([
            'route_lock' => RouteMaintenanceMode::class,
            'standardization.documents.uploaded' => StandardizationDocumentsUploadedMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
