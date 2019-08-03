<?php

require_once("config.php");

// $sql = new Sql();
// $usuarios = $sql->select("SELECT * FROM tb_usuarios");
// echo json_encode($usuarios);

//carrega um usuario
// $root = new Usuario();
// $root->loadById(3);
// echo $root;

//carrega uma lista de usuarios
// $lista = Usuario::getList();
// echo json_encode($lista);

//carrega uma lista de usuarios buscando pelo login
// $search = Usuario::search("ro");
// echo json_encode($search);

//carrega um usuario usando o login e a senha
// $usuario = new Usuario();
// $usuario->login("root", "!@#$%");
// echo $usuario;

//criando um novo usuario
// $aluno = new Usuario("aluno", "@lun0");
// $aluno->insert();
// echo $aluno;

$usuario = new Usuario();
$usuario->loadById(8);
$usuario->update("professor", "!@#$%&*");
echo $usuario;
?>