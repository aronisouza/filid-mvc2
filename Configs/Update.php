<?php
class Update extends CRUD
{
    /**
     * Executa uma atualização no banco de dados
     * 
     * @param string $tabela Nome da tabela
     * @param array $dados Dados a serem atualizados
     * @param string $termos Termos da consulta (WHERE, etc.)
     * @param string $parseString String de parâmetros
     * @return bool
     */
    public function ExeUpdate($tabela, array $dados, $termos, $parseString)
    {
        $this->tabela = $this->validarTabela($tabela);
        $this->dados = $this->validarDados($dados);
        $this->termos = $termos;
        $this->places = $this->parsePlaces($parseString);
        
        $sets = [];
        foreach ($this->dados as $coluna => $valor) {
            $sets[] = "{$coluna} = :{$coluna}";
        }
        
        $sets = implode(', ', $sets);
        $query = "UPDATE {$this->tabela} SET {$sets} {$this->termos}";
        
        $params = array_merge($this->dados, $this->places);
        
        if ($this->executeQuery($query, $params)) {
            $this->result = true;
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
    public function FullUpdate($query, $parseString = null)
    {
        $this->query = $query;
        $this->dados = [];
        $this->places = $this->parsePlaces($parseString);
        
        $params = array_merge($this->dados, $this->places);
        
        if ($this->executeQuery($this->query, $params)) {
            $this->result = true;
            return true;
        }
        
        return false;
    }
}