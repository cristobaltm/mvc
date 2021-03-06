<?php

class UsersController extends Controller {

	public function __construct() {
		parent::__construct();
		$this->name = "users";
		parent::loadModel($this->name);
	}

	public function showList() {
		//Conseguimos todos los usuarios
		$allusers = $this->model->getAll();
		$allusersHTML = $this->view->userTable($allusers);

		return $allusersHTML;
	}

	public function main() {
		$this->writeView($this->name, array(
			'content' => $this->getContent('users'),
			'path_vendor' => PATH_SITE . PATH_VENDOR,
			'form_action' => $this->view->url("users", "insert"),
		));
	}

	private function getContent($html) {
		$replace = array(
			'users_table' => $this->showList()
		);
		return $this->view->writeHTML($html, $replace);
	}

	public function insert() {

		$name = filter_input(INPUT_POST, "name");
		$surname = filter_input(INPUT_POST, "surname");
		$email = filter_input(INPUT_POST, "email");
		$password = filter_input(INPUT_POST, "password");
		$description = filter_input(INPUT_POST, "description");

		if (!empty($name)) {

			//Creamos un usuario
			$this->model->setNombre($name);
			$this->model->setApellido($surname);
			$this->model->setEmail($email);
			$this->model->setPassword(sha1($password));
			$this->model->setDescription($description);
			$this->model->save();
		}
		$this->redirect("users", "main");
	}

	public function delete() {
		$id = (int) $this->url_var[1];
		if (!empty($id)) {
			$this->model->remove($id);
		}
		$this->redirect("users", "main");
	}

}
