<?php

    class Mercado{
        private $pdo;
        public function __construct($dbname, $host, $user, $senha){
            try{
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
            }catch(PDOException $e){
                echo "Erro ao conectar ao banco de dados: ".$e->getMessage();
                exit();
            }catch(Exception $e){
                echo "Erro genérico: ".$e->getMessage();
                exit();
            }
        }
        public function buscarDadosProdutos(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM tb_produtos");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        public function buscarDadosVendas(){
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM tb_vendas JOIN tb_produtos ON tb_vendas.cod_produto = tb_produtos.id_produto");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        public function cadastrarProduto($nome, $codigo){
            $cmd = $this->pdo->prepare("SELECT id_produto FROM tb_produtos WHERE nome_produto = :n");
            $cmd->bindValue(":n", $nome);
            $cmd->execute();

            if($cmd->rowCount() > 0){
                return false;
            }else{
                $cmd = $this->pdo->prepare("INSERT INTO tb_produtos (nome_produto, codigo_de_barra) VALUES (:n, :c)");
                $cmd->bindValue(":n", $nome);
                $cmd->bindValue(":c", $codigo);
                $cmd->execute();
                return true;
            }
        }
        public function cadastrarVenda($comprador, $preco, $quantidade, $cod_produto){
            $cmd = $this->pdo->prepare("INSERT INTO tb_vendas (comprador, preco, quantidade, cod_produto) VALUES (:c, :p, :q, :cod)");
            $cmd->bindValue(":c", $comprador);
            $cmd->bindValue(":p", $preco);
            $cmd->bindValue(":q", $quantidade);
            $cmd->bindValue(":cod", $cod_produto);
            $cmd->execute();
            return true;
        }
        public function excluirProduto($id){
            $cmd = $this->pdo->prepare("DELETE FROM tb_vendas WHERE cod_produto = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();

            $cmd = $this->pdo->prepare("DELETE FROM tb_produtos WHERE id_produto = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return true;
        }
        public function excluirVenda($id){
            $cmd = $this->pdo->prepare("DELETE FROM tb_vendas WHERE id_venda = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }
        public function buscarDadosProdutoEsp($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT nome_produto, codigo_de_barra FROM tb_produtos WHERE id_produto = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
        public function atualizarProduto($id, $nome, $codigo){
            $cmd = $this->pdo->prepare("UPDATE tb_produtos SET nome_produto = :n, codigo_de_barra = :c WHERE id_produto = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":c", $codigo);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }
        public function buscarDadosVendaEsp($id){
            $res = array();
            $cmd = $this->pdo->prepare("SELECT comprador, preco, quantidade, cod_produto FROM tb_vendas WHERE id_venda = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC);
            return $res;
        }
        public function atualizarVenda($id, $comprador, $preco, $quantidade, $cod_produto){
            $cmd = $this->pdo->prepare("UPDATE tb_vendas SET comprador = :c, preco = :p, quantidade = :q, cod_produto = :cod WHERE id_venda = :id");
            $cmd->bindValue(":c", $comprador);
            $cmd->bindValue(":p", $preco);
            $cmd->bindValue(":q", $quantidade);
            $cmd->bindValue(":cod", $cod_produto);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }
    }

?>