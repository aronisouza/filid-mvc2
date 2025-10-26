<?php
abstract class CRUD extends Conexao
{
    protected $tabela;
    protected $dados;
    protected $termos;
    protected $places;
    protected $result;
    protected $query;
    protected $conn;

    /**
     * Construtor - inicializa a conexão
     */
    public function __construct()
    {
        $this->conn = parent::getConn();
    }

    /**
     * Obtém o resultado da operação
     * 
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Obtém o número de linhas afetadas
     * 
     * @return int
     */
    public function getRowCount()
    {
        if (isset($this->query)) {
            return $this->query->rowCount();
        }
        return 0;
    }

    /**
     * Prepara e executa uma query
     * 
     * @param string $query
     * @param array $params
     * @return bool
     */
    protected function executeQuery($query, $params = [])
    {
        try {
            $this->query = $this->conn->prepare($query);
            $this->query->execute($params);
            return true;
        } catch (\PDOException $e) {
            $this->result = null;
            if ($e->getCode() == 23000) {
                // 23000 = código SQLSTATE para violação de restrição (ex: UNIQUE)
                $this->setMensageAndRedirect(
                    "Já existe uma relação com os dados informados.",
                    "/listas",
                    "Alerta",
                    "warning"
                );
            }
            logError("Erro PDO: " . preg_replace('/password=[^&]+/', 'password=***', $e->getMessage()));
        }
    }

    /**
     * Valida o nome da tabela
     * 
     * @param string $tabela
     * @return string
     */
    protected function validarTabela($tabela)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tabela)) {
            throw new InvalidArgumentException("Nome de tabela inválido: $tabela");
        }
        return $tabela;
    }

    /**
     * Valida o nome da coluna
     * 
     * @param string $coluna
     * @return string
     */
    protected function validarColuna($coluna)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $coluna)) {
            throw new InvalidArgumentException("Nome de coluna inválido: $coluna");
        }
        return $coluna;
    }

    /**
     * Processa a string de parâmetros
     * 
     * @param string $parseString
     * @return array
     */
    protected function parsePlaces($parseString)
    {
        if (empty($parseString)) {
            return [];
        }

        $places = [];
        parse_str($parseString, $places);
        return array_filter($places, 'is_scalar');
    }

    /**
     * Valida os dados antes de operações
     * 
     * @param array $dados
     * @return array
     */
    protected function validarDados(array $dados)
    {
        $dadosValidados = [];

        foreach ($dados as $coluna => $valor) {
            $coluna = $this->validarColuna($coluna);
            $dadosValidados[$coluna] = $valor;
        }

        return $dadosValidados;
    }
}
