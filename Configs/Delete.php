<?php
class Delete extends CRUD
{
    /**
     * Executa uma exclusão no banco de dados
     * 
     * @param string $tabela Nome da tabela
     * @param string $termos Termos da consulta (WHERE, etc.)
     * @param string $parseString String de parâmetros
     * @return bool
     */
    public function ExeDelete($tabela, $termos, $parseString)
    {
        $this->tabela = $this->validarTabela($tabela);
        $this->termos = $termos;
        $this->places = $this->parsePlaces($parseString);
        
        $query = "DELETE FROM {$this->tabela} {$this->termos}";
        
        if ($this->executeQuery($query, $this->places)) {
            $this->result = true;
            return true;
        }
        
        return false;
    }
}