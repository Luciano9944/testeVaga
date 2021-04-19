<?php

// verifica se as variaveis de vaga foram enviadas via post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nomevaga = (isset($_POST["nomevaga"]) && $_POST["nomevaga"] != null) ? $_POST["nomevaga"] : "";
    $descricao = (isset($_POST["descricao"]) && $_POST["descricao"] != null) ? $_POST["descricao"] : "";
} else if (!isset($id)) {
    //atribui um valor para o id caso ele esteja vazio
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nomevaga = NULL;
    $descricao = NULL;
}

// verifica se as variaveis do candidato foram enviadas via post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idcandidato = (isset($_POST["idcandidato"]) && $_POST["idcandidato"] != null) ? $_POST["idcandidato"] : "";
    $nomecandidato = (isset($_POST["nomecandidato"]) && $_POST["nomecandidato"] != null) ? $_POST["nomecandidato"] : "";
    $cep = (isset($_POST["cep"]) && $_POST["cep"] != null) ? $_POST["cep"] : "";
    $vagadeinteresse = (isset($_POST["vagadeinteresse"]) && $_POST["vagadeinteresse"] != null) ? $_POST["vagadeinteresse"] : "";
} else if (!isset($idcandidato)) {
    //atribui um valor para o idcandidato caso ele esteja vazio
    $idcandidato = (isset($_GET["idcandidato"]) && $_GET["idcandidato"] != null) ? $_GET["idcandidato"] : "";
    $nomecandidato = NULL;
    $cep = NULL;
    $vagadeinteresse = NULL;
}
//este bloco faz a conexão com o baco de dados
try {
    $conexao = new PDO("mysql:host=localhost; dbname=cadastrovagas", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    echo "Erro ao conectar:" . $erro->getMessage();
}
//                  area que atualiza, deleta e insere uma vaga
//
//insere uma vaga nova ou faz o update de uma vaga
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nomevaga != "") {
    try {
        //se entrar no if, quer dizer que o id não está vazio, então é um update
        if ($id != ""){
            $stmt = $conexao->prepare("UPDATE vaga SET nomevaga=?, descricao=? WHERE id = ?");
            $stmt->bindParam(3, $id);
        }
        //se cair no else, o id é vazio, então é um insert
        else{
            $stmt = $conexao->prepare("INSERT INTO vaga (nomevaga, descricao) VALUES (?, ?)");
        }

        $stmt->bindParam(1, $nomevaga);
        $stmt->bindParam(2, $descricao);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "ação realizada com sucesso";
                $id = null;
                $nomevaga = null;
                $descricao = null;
            } else {
                echo "Erro ao cadastrar a vaga";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar o SQL");
        }
    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }
}
//atualiza uma vaga
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM vaga WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nomevaga = $rs->nomevaga;
            $descricao = $rs->descricao;
        } else {
            throw new PDOException("Erro: Não foi possível executar o SQL");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
//Deleta uma vaga
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM vaga WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Vaga excluida com sucesso";
            $id = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar o SQL");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
//
//                          area que atualiza, insere e deleta um canditato

//insere um candidato novo ou faz o update de um candidato
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nomecandidato != "") {
    try {
        //se entrar no if, quer dizer que o id não está vazio, então é um update
        if ($idcandidato != ""){
            $stmt = $conexao->prepare("UPDATE candidato SET nomecandidato=?, cep=?, vagadeinteresse=? WHERE idcandidato = ?");
            $stmt->bindParam(4, $idcandidato);
        }
        //se cair no else, o id é vazio, então é um insert
        else{
            $stmt = $conexao->prepare("INSERT INTO candidato (nomecandidato, cep, vagadeinteresse) VALUES (?, ?, ?)");
        }
        $stmt->bindParam(1, $nomecandidato);
        $stmt->bindParam(2, $cep);
        $stmt->bindParam(3, $vagadeinteresse);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "ação realizada com sucesso";
                $idcandidato = null;
                $nomecandidato = null;
                $cep = null;
                $vagadeinteresse = null;
            } else {
                echo "Erro ao cadastrar o candidato";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar o SQL");
        }
    } catch (PDOException $erro) {
        echo "Erro: " . $erro->getMessage();
    }
}

//atualiza um candidato
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idcandidato != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM candidato WHERE idcandidato = ?");
        $stmt->bindParam(1, $idcandidato, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $idcandidato = $rs->idcandidato;
            $nomecandidato = $rs->nomecandidato;
            $cep = $rs->cep;
            $vagadeinteresse = $rs->vagadeinteresse;
        } else {
            throw new PDOException("Erro: Não foi possível executar o SQL");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
//Deleta um candidato
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idcandidato != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM candidato WHERE idcandidato = ?");
        $stmt->bindParam(1, $idcandidato, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Candidato excluido com sucesso";
            $idcandidato = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar o SQL");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Vagas e Pessoas</title>
</head>
<body>
<form action="?act=save" method="POST" name="form1" >
    <h1>Cadastro e Update de vagas</h1>
    <hr>
    <input type="hidden" name="id" <?php
    if (isset($id) && $id != null || $id != ""){
                echo "value=\"{$id}\"";
    } ?> />
    Nome da Vaga:
    <input type="text" name="nomevaga" <?php
    if (isset($nomevaga) && $nomevaga != null || $nomevaga != "") {
                echo "value=\"{$nomevaga}\"";
    }?> />
    Descrição:
    <input type="text" name="descricao" <?php
    if (isset($descricao) && $descricao != null || $descricao != "") {
        echo "value=\"{$descricao}\"";
    }?> />
    <input type="submit" value="salvar" />
    <hr>
</form>
<h1>Lista de vagas disponiveis</h1>
<table border="1" width="100%">
    <tr>
        <th>id</th>
        <th>Nome da Vaga</th>
        <th>Descrição</th>
        <th>Ações</th>
    </tr>
    <?php
    // Lista todas as vagas cadastradas
    try {
        $stmt = $conexao->prepare("SELECT * FROM vaga");
        if ($stmt->execute()) {
            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>";
                echo "<td>".$rs->id."</td>"."<td>".$rs->nomevaga."</td><td>".$rs->descricao."</td><td><center><a href=\"?act=upd&id=" . $rs->id . "\">[Alterar]</a>"
                    ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    ."<a href=\"?act=del&id=" . $rs->id . "\">[Excluir]</a></center></td>";
                echo "</tr>";
            }
        } else {
            echo "Erro: Não foi possível listas as vagas do banco de dados";
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
    ?>
</table>

<h1>Cadastro e Update de de Candidatos</h1>
<hr>
<form action="?act=save" method="POST" name="form2" >
<input type="hidden" name="idcandidato" <?php
if (isset($idcandidato) && $idcandidato != null || $idcandidato != ""){
    echo "value=\"{$idcandidato}\"";
} ?> />
Nome:
<input type="text" name="nomecandidato" <?php
if (isset($nomecandidato) && $nomecandidato != null || $nomecandidato != "") {
    echo "value=\"{$nomecandidato}\"";
}?> />
CEP:
<input type="text" name="cep" <?php
if (isset($cep) && $cep != null || $cep != "") {
    echo "value=\"{$cep}\"";
}?> />
Vaga de interesse:
<input type="text" name="vagadeinteresse" <?php
if (isset($vagadeinteresse) && $vagadeinteresse != null || $vagadeinteresse != "") {
    echo "value=\"{$vagadeinteresse}\"";
}?> />
<input type="submit" value="salvar" />
</form>
<hr>
<h1>Lista de Candidatos</h1>
<table border="1" width="100%">
    <tr>
        <th>Nome do candidato</th>
        <th>Endereço</th>
        <th>Vaga de interesse</th>
        <th>Ações</th>
    </tr>
    <?php
    // Lista todos os candidatos cadastrados
    try {
        $stmt = $conexao->prepare("SELECT * FROM candidato");
        if ($stmt->execute()) {
            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>";
                echo "<td>".$rs->nomecandidato."</td>"."<td>".tratarjson($rs->cep)."</td><td>".$rs->vagadeinteresse."</td><td><center><a href=\"?act=upd&idcandidato=" . $rs->idcandidato . "\">[Alterar]</a>"
                    ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    ."<a href=\"?act=del&idcandidato=" . $rs->idcandidato . "\">[Excluir]</a></center></td>";
                echo "</tr>";
            }
        } else {
            echo "Erro: Não foi possível listas as vagas do banco de dados";
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }

    function tratarjson($cep){
        $url = "https://viacep.com.br/ws/".$cep."/json/";
        $endereco = json_decode(file_get_contents($url));
        $teste = "Rua: ".$endereco->logradouro."<br>"."Bairro:".$endereco->bairro."<br>"."cep".$endereco->cep."<br>";
        $teste = $teste."Cidade: ".$endereco->localidade.",".$endereco->uf;

        return $teste;
    }
    ?>


</body>
</html>
