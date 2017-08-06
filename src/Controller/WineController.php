<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Wine;

class WineController
{
    public function listAll(Application $app, Request $request)
    {
        $wines = Wine::orderBy('name')->get();

        return $app->json($wines, 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function get(Application $app, Request $request, $id)
    {
        $wine = Wine::find($id);

        if(!$wine) {
            return $app->json(['message' => 'Id not found'], 404);
        }

        return $app->json($wine, 200);
    }

    public function create(Application $app, Request $request)
    {
        try {
            if($request->request->get('name') == '') {
               return $app->json(['error' => 'Field \'name\' is required.'], 400); 
            }

            $wine = new Wine();
            $wine->fill($request->request->all());
            $wine->save();

            return $app->json($wine, 201)->setEncodingOptions(JSON_NUMERIC_CHECK);
        }
        catch (\Exception $e) {
            return $app->json(['error' => 'Was not possible create a wine'], 500);
        }
    }

    public function update(Application $app, Request $request, $id)
    {
        try {
            if($request->request->get('name') == '') {
               return $app->json(['error' => 'Field \'name\' is required.'], 400); 
            }

            $wine = Wine::find($id);

            if(!$wine) {
                return $app->json(['message' => 'Id not found'], 404);
            }

            $wine->fill($request->request->all());
            $wine->save();

            return $app->json($wine, 200)->setEncodingOptions(JSON_NUMERIC_CHECK);
        }
        catch (\Exception $e) {
            return $app->json(array('error' => 'Was not possible to update the wine data'), 500);
        }
    }

    public function delete(Application $app, Request $request, $id)
    {
        $wine = Wine::find($id);

        if(!$wine) {
            return $app->json(['message' => 'Id not found'], 404);
        }

        try {
            $wine->delete();

            return $app->json(array('message' => 'Wine successful deleted'), 200);
        }
        catch(\Exception $e) {
            return $app->json(array('error' => 'Was not possible to delete the wine'), 500);
        }
    }
}