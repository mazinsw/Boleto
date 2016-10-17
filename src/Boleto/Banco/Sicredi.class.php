<?php
/**
 * MIT License
 * 
 * Copyright (c) 2016 MZSW CREATIVE SOFTWARE
 * 
 * @author Francimar Alves <mazinsw@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */
namespace Boleto\Banco;

use Boleto\Banco;
use Boleto\Util\Utilitario;
use Boleto\Util\BarCode;
use Exception;

/**
 * Banco que estende de uma carteira e implementa um retorno
 */
class Sicredi extends Banco
{

	/**
	 * Código do posto da cooperativa de crédito
     * @var string
	 */
	private $posto;

	/**
	 * Número da geração do nosso número, quando não informado, 
	 * será gerado automaticamente
	 *
     * @var string
	 */
	private $geracao;

	public function __construct($sicredi = array())
	{
		$this->fromArray($sicredi);
		$this->setCodigo('748');
		$this->setLogo('sicredi.png');
		$this->setFantasia('Sicredi');
		$this->setNome('Sicredi');
	}

	/**
	 * Código do posto de atendimento do banco
	 */
	public function getPosto()
	{
		return $this->posto;
	}

	public function setPosto($posto)
	{
		$this->posto = $posto;
		return $this;
	}

	/**
	 * Número da geração do nosso número, quando não informado, será gerado automaticamente
	 */
	public function getGeracao()
	{
		return $this->geracao;
	}

	public function setGeracao($geracao)
	{
		$this->geracao = $geracao;
		return $this;
	}

	/**
	 * Calcula o código de barras através das informações do boleto
	 */
	public function getCodigoBarras()
	{
		$especie = $this->getConfiguracao()->getEspecie();
		if($especie != 'R$')
			throw new Exception('Espécie de moeda "'.$especie.'" não suportada');
		$nosso_numero = $this->getNossoNumero();
		$agencia = Utilitario::getDigitos($this->getCarteira()->getAgencia());
		$cod_cedente = Utilitario::getDigitos($this->getBoleto()->getBeneficiario()->getCodigo());
		
		$codbarras  = Utilitario::padDigit($this->getCodigo(), 3); // Identificação do banco
		$codbarras .= '9'; // código para R$ (Real)
		$codbarras .= ''; // Dígito verificador geral do código de barras
		$codbarras .= $this->getBoleto()->getFatorVencimento(); // Fator de vencimento (não obrigatório)
		$codbarras .= Utilitario::padMoeda($this->getBoleto()->getValor(), 10); // Valor

		$campolivr  = $this->getBoleto()->isAceite()?'1':'3'; // Tipo de cobrança
		$campolivr .= '1'; // Carteira simples
		$campolivr .= Utilitario::padDigit($nosso_numero, 9); // Nosso número
		$campolivr .= Utilitario::padDigit($agencia, 4); // Cooperativa de crédito ou Agência cedente
		$campolivr .= Utilitario::padDigit($this->getPosto(), 2); // Posto beneficiário
		$campolivr .= Utilitario::padDigit($cod_cedente, 5); // Código do cedente
		$campolivr .= is_null($this->getBoleto()->getValor())?'0':'1'; // Valor fixo
		$campolivr .= '0'; // Filler zeros
		$campolivr .= Utilitario::getDAC($campolivr, 11); // Dígito verificador do campo livre

		$codbarras .= $campolivr;
		$dv = Utilitario::getDAC($codbarras, 11, 1); // Dígito verificador geral do código de barras
		return substr_replace($codbarras, $dv, 4, 0);
	}

	/**
	 * Calcula o código da linha digitável
	 */
	public function getLinhaDigitavel($formatado = false)
	{
		$codbarras = $this->getCodigoBarras();
		$campo1  = substr($codbarras, 0, 4);
		$campo1 .= substr($codbarras, 19, 5);
		$campo1 .= Utilitario::getDAC($campo1, 10);

		$campo2  = substr($codbarras, 24, 10);
		$campo2 .= Utilitario::getDAC($campo2, 10);

		$campo3  = substr($codbarras, 34, 10);
		$campo3 .= Utilitario::getDAC($campo3, 10);

		$campo4  = substr($codbarras, 4, 1);

		$campo5  = substr($codbarras, 5, 14);

		$linha = $campo1.$campo2.$campo3.$campo4.$campo5;
		if(!$formatado)
			return $linha;
		return Utilitario::mascarar($linha, BarCode::MASK);
	}

	/**
	 * Obtém o código da agência com o código do posto e do beneficiário
	 */
	public function getAgenciaCodigo()
	{
		return $this->getCarteira()->getAgencia() . '.' . 
			$this->getPosto() . '.' .
			$this->getBoleto()->getBeneficiario()->getCodigo();
	}

	/**
	 * Obtém o código Nosso número já processado
	 */
	public function getNossoNumero($formatar = false)
	{
		$numero = $this->getBoleto()->getNumero();
		if(strlen($numero) > 6)
			throw new Exception('O banco "'.$this->getFantasia().'" não suporta mais de 6 dígitos no nosso número');
		$_geracao = $this->getGeracao();
		$geracao = 2;
		if(strlen($numero) == 6) {
			$excesso = substr($numero, 0, 1);
			if(!is_null($_geracao) && $_geracao != $excesso)
				throw new Exception('O número da geração informado é diferente do sexto dígito do nosso número');
			if(is_null($_geracao))
				$geracao += $excesso;
			$numero = substr($numero, 1);
		}
		if($geracao < 2 || $geracao > 9)
			throw new Exception('Número de geração inválido "'.$geracao.'", o número deve estar compreendido entre 2 e 9');
		$ano = date('y', $this->getBoleto()->getDataEmissao());
		$nosso_numero = $ano.$geracao.$numero;
		$agencia = Utilitario::getDigitos($this->getCarteira()->getAgencia());
		$cod_cedente = Utilitario::getDigitos($this->getBoleto()->getBeneficiario()->getCodigo());
		$codigos  = Utilitario::padDigit($agencia, 4); // Cooperativa de crédito ou Agência cedente
		$codigos .= Utilitario::padDigit($this->getPosto(), 2); // Posto beneficiário
		$codigos .= Utilitario::padDigit($cod_cedente, 5); // Código do cedente
		$codigos .= $nosso_numero;
		$nosso_numero .= Utilitario::getDAC($codigos, 11);
		if($formatar)
			return Utilitario::mascarar($nosso_numero, '99/999999-9');
		return $nosso_numero;
	}

	/**
	 * Obtém o dígito verificador do banco
	 */
	public function getDigitoVerificador()
	{
		return 'X';
	}

	/**
	 * Obtém o local de pagamento
	 */
	public function getLocalPagamento()
	{
		return 'PAGÁVEL PREFERENCIALMENTE NAS COOPERATIVAS DE CRÉDITO DO Sicredi';
	}

	/**
	 * Obtém o arquivo de remessa dos boletos informados
	 *
	 * @param array $boletos
	 *
	 * @return string
	 */
	public function getArquivo($boletos)
	{
		// TODO: Implementar geração do arquivo de remessa
		return '';
	}

	/**
	 * Obtém todos os boletos já processados pelo banco no formato de Retorno
	 *
	 * @param string $arquivo
	 *
	 * @return array
	 */
	public function getRetornos($arquivo)
	{
		// TODO: Implementar leitura do arquivo de retorno
		return array();
	}

	/**
	 * Retorna as informações do banco em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$banco = parent::toArray();
		$banco['posto'] = $this->getPosto();
		$banco['geracao'] = $this->getGeracao();
		return $banco;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Sicredi informações do banco
	 */
	public function fromArray($banco = array())
	{
		if($banco instanceof Banco)
			$banco = $banco->toArray();
		else if(!is_array($banco))
			return $this;
		parent::fromArray($banco);
		$this->setPosto($banco['posto']);
		$this->setGeracao($banco['geracao']);
		return $this;
	}

}