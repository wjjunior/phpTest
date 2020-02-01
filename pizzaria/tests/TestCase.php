<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function create(string $model, array $attributes =  [], $resource = true)
    {
        $resourceModel = factory("App\\$model")->create($attributes);
        $resourceClass = "App\\Http\Resources\\$model";

        if (!$resource) return $resourceModel;

        return new $resourceClass($resourceModel);
    }
}
