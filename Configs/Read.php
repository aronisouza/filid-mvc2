<?php
class Read extends CRUD
{
    /**
     * Executa uma leitura no banco de dados
     * 
     * @param string $tabela Nome da tabela
     * @param string $termos Termos da consulta (WHERE, ORDER BY, LIMIT, etc.)
     * @param string $parseString String de parâmetros
     * @param string $colunas Colunas a serem selecionadas
     * @return bool
     */
    public function ExeRead($tabela, $termos = null, $parseString = null, $colunas = '*')
    {
        $this->tabela = $this->validarTabela($tabela);
        $this->termos = $termos;
        $this->places = $this->parsePlaces($parseString);
        
        $query = "SELECT {$colunas} FROM {$this->tabela}";
        if ($this->termos) {
            $query .= " {$this->termos}";
        }
        
        if ($this->executeQuery($query, $this->places)) {
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);
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
    public function FullRead($query, $parseString = null)
    {
        $this->places = $this->parsePlaces($parseString);
        
        if ($this->executeQuery($query, $this->places)) {
            $this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);
            return true;
        }
        
        return false;
    }
}