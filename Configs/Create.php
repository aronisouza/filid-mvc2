<?php
class Create extends CRUD
{
    /**
     * Executa um cadastro no banco de dados
     * 
     * @param string $tabela Nome da tabela
     * @param array $dados Dados a serem inseridos
     * @return bool
     */
    public function ExeCreate($tabela, array $dados)
    {
        $this->tabela = $this->validarTabela($tabela);
        $this->dados = $this->validarDados($dados);
        
        $colunas = implode(', ', array_keys($this->dados));
        $valores = ':' . implode(', :', array_keys($this->dados));
        
        $query = "INSERT INTO {$this->tabela} ({$colunas}) VALUES ({$valores})";
        
        if ($this->executeQuery($query, $this->dados)) {
            $this->result = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
     * Executa uma query personalizada
     * 
     * @param string $query Query SQL
     * @param string $parseString String de parâmetros
     * @return bool
     */
    public function FullCreate($query, $parseString = null)
    {
        $this->query = $query;
        $this->dados = [];
        $this->places = $this->parsePlaces($parseString);
        
        return $this->executeQuery($this->query, array_merge($this->dados, $this->places));
    }
}