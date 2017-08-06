<?php
define("APP_ROOT", dirname(__DIR__));
chdir(APP_ROOT);
require_once "vendor/autoload.php";

use Silex\Application;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();
$app["debug"] = true;

// Setup DB Connectivity through Illuminate\Database
$capsule = new Capsule();
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'app',
    'username'  => 'andre',
    'password'  => '7035489',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models
$capsule->setEventDispatcher(new Dispatcher(new Container));
// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();
// Setup the Eloquent ORM
$capsule->bootEloquent();

$app->before(function() use ($app) {
    // Check whether there is auth data or not in the request
    if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] == "") {
        header('WWW-Authenticate: Basic realm=\'TestApi\'');
        return $app->json(['Message' => 'Not Authorised'], 401);
    } else {

        // If there is, check whether the user is allowed to proceed.
        $users = [
            'andre' => '1234'
        ];

        if($users[$_SERVER['PHP_AUTH_USER']] !== $_SERVER['PHP_AUTH_PW']) {
            return $app->json(['Message' => 'Forbidden'], 403);
        }
    }
});

$app->get("/", function(Application $app) {
    return $app->json(["API Running"]);
});

/** Get all jobs */
$app->get("/jobs", function() use ($app) {
    return $app->json(Model\Job::all()->toArray());
});

/** Get a job */
$app->get("/jobs/{id}", function($id) use ($app) {
    return $app->json(Model\Job::find($id));
})->convert("id", function($id) {
    return (int) $id;
});

/** Insert a job */
$app->post("/jobs", function(Request $request) use ($app) {
    $required_attr = ["name", "description", "requirements", "initial_salary"];
    $data = json_decode($request->getContent());
    $job = new Model\Job();

    foreach($required_attr as $attr) {
        if($data->$attr != "") {
            $job->$attr = $data->$attr;
        } else {
            return $app->json([
                "status" => 0,
                "message" => "Required parameter \"{$attr}\" not informed."
            ]);
        }
    }

    if($job->save()) {
        return $app->json([
            "status" => 1,
            "message" => "Job successfully added."
        ]);
    } else {
        return $app->json([
            "status" => 0,
            "message" => "Failed to add the job."
        ]);
    }
});

/** Update a job */
$app->put("/jobs", function(Request $request) use ($app) {
    $required_attr = ["name", "description", "requirements", "initial_salary"];
    $data = json_decode($request->getContent());

    if($data->id != "") {
        $job = Model\Job::find($data->id);
    } else {
        return $app->json([
            "status" => 0,
            "message" => "Required parameter 'id' not informed."
        ]);
    }

    if(!($job instanceof Model\Job)) {
        return $app->json([
            "status" => 0,
            "message" => "No Job could be found with the informed id."
        ]);
    }

    foreach($required_attr as $attr) {
        if ($data->$attr != "") {
            $job->$attr = $data->$attr;
        } else {
            return $app->json([
                "status" => 0,
                "message" => "Required parameter '{$attr}' not informed."
            ]);
        }
    }

    if ($job->update()) {
        return $app->json([
            "status" => 1,
            "message" => "Job successfully updated."
        ]);
    } else {
        return $app->json([
            "status" => 0,
            "message" => "Failed to update the job."
        ]);
    }
});

/** Delete a job */
$app->delete("/jobs/{id}", function($id) use ($app) {
    if(Model\Job::destroy($id)) {
        return $app->json([
            "status" => 1,
            "message" => "Job successfully deleted."
        ]);
    } else {
        return $app->json([
            "status" => 0,
            "message" => "Failed to delete the job."
        ]);
    }
});

$app->run();