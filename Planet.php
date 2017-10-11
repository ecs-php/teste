<?php

class Planet {

	public static function getAll(){
		global $app;

		$result = $app['db']->fetchAll("SELECT * FROM planet LIMIT 50");
		
		return $result;
	}

	public static function insert($data){
		global $app;

		$sql = "INSERT INTO planet (name, galaxy, size, distance, date_created, date_updated) VALUES (?, ?, ?, ?, ?, ?)";
		$app['db']->executeQuery($sql, array($data->get('name'), $data->get('galaxy'), $data->get('size'), $data->get('distance'), date('Y-m-d H:i:s'), date('Y-m-d H:i:s')));
		return Planet::get($app['db']->lastInsertId());

	}

	public static function get($id){
		global $app;

		$result = $app['db']->fetchAssoc("SELECT * FROM planet WHERE id = ?", array($id));

		return $result;
	}

	public static function update($data, $id){
		global $app;

		$values = array();
		$sql = "UPDATE planet SET name = ?, galaxy = ?, size = ?, distance = ?, date_updated = ? WHERE id = ?";
		$app['db']->executeUpdate($sql, array($data->get('name'), $data->get('galaxy'), $data->get('size'), $data->get('distance'), date('Y-m-d H:i:s'), $id));
		return true;

	}

	public static function delete($id){
		global $app;

		$app['db']->executeQuery("DELETE FROM planet WHERE id = ?", array($id));

		return true;
	}
}