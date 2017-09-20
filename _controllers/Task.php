<?php
namespace Tgenuino;

use Symfony\Component\HttpFoundation\JsonResponse;

class Task {
  function __construct($app) {
    $this->app = $app;
  }

  function listTasks($request, $app) {
    $sql = [];
    $values = [];

    $sql[] = 'SELECT * FROM tasks';

    if ($request->query->get('term')) {
      $sql[] = 'WHERE title LIKE ?';
      $values[] = '%'.$request->query->get('term').'%';
      $sql[] = 'OR id = ?';
      $values[] = $request->query->get('term');
    }

    $sql[] = 'ORDER BY date DESC,title';

    $tasks = $this->app['db']->executeQuery(join($sql, ' '), $values);

    return new JsonResponse(array(
      'results' => $tasks->fetchAll()
    ));
  }

  function insertTask($request, $app) {
    return $this->app['db']->insert('tasks', $request->request->all());
  }

  function updateTask($request, $app, $id) {
    $data = [];
    parse_str($request->getContent(), $data);
    $data['updated_by'] = $app['session']->get('user')['id'];
    $data['updated_at'] = \date("Y-m-d H:i:s");

    $values = [];
    $buildFields = [];

    foreach ($data as $key => $value) {
      if ($key == 'id') continue;

      $values[] = $value;
      $buildFields[] = $key . ' = ? ';
    }

    $sql = 'UPDATE tasks SET ' . join($buildFields, ',') . " WHERE id = ?";
    $values[] = $id;

    return $this->app['db']->executeUpdate($sql, $values);
  }

  function deleteTask($request, $app) {
    $data = [];
    parse_str($request->getContent(), $data);

    $sql = 'DELETE FROM tasks WHERE id = ?';

    return !!$this->app['db']->executeQuery($sql, [$data['id']]);
  }
}

?>