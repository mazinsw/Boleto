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
namespace Boleto;

use Boleto\Util\Utilitario;

/**
 * Boleto de cobrança
 */
class Boleto
{

	/**
	 * Nosso número
     * @var string
	 */
	private $numero;

	/**
	 * Valor do boleto
     * @var string
	 */
	private $valor;

	/**
	 * Quantidade
     * @var string
	 */
	private $quantidade;

	/**
	 * Data de vencimento do boleto
     * @var string
	 */
	private $data_vencimento;

	/**
	 * Número do documento
     * @var string
	 */
	private $documento;

	/**
	 * Data de emissão do boleto
     * @var string
	 */
	private $data_emissao;

	/**
	 * Data de processamento do boleto (Opcional)
     * @var string
	 */
	private $data_processamento;

	/**
	 * O campo Aceite indica se o Pagador (quem recebe o boleto) aceitou o
	 * boleto, ou seja, se ele assinou o documento de cobrança que originou o
	 * boleto
     * @var boolean
	 */
	private $aceite;

	/**
	 * Espécie do documento
     * @var string
	 */
	private $especie_documento;

	/**
	 * Texto ou array de instruções sobre o boleto
     * @var string|array
	 */
	private $instrucoes;

	/**
	 * Banco que processará esse boleto
     * @var Banco
	 */
	private $banco;

	/**
	 * Cliente que irá pagar esse boleto
     * @var Empresa|Cliente
	 */
	private $cliente;

	/**
	 * Empresa ou Pessoa que irá receber o pagamento desse boleto
     * @var Empresa|Cliente
	 */
	private $beneficiario;

	/**
	 * Configuração do boleto
     * @var Configuracao
	 */
	private $configuracao;

	/**
	 * Formato de geração do boleto: PDF, HTML ou PNG
     * @var Formato
	 */
	private $formato;

	public function __construct($boleto = array())
	{
		$this->fromArray($boleto);
		if(is_array($boleto) && !isset($boleto['configuracao']))
			$this->setConfiguracao(new Configuracao());
		if(is_array($boleto) && !isset($boleto['dataemissao']))
			$this->setDataEmissao(time());
		if(is_array($boleto) && !isset($boleto['aceite']))
			$this->setAceite(false);
	}

	/**
	 * Nosso número
	 */
	public function getNumero()
	{
		return $this->numero;
	}

	public function setNumero($numero)
	{
		$this->numero = $numero;
		return $this;
	}

	/**
	 * Valor do boleto
	 */
	public function getValor()
	{
		return $this->valor;
	}

	public function setValor($valor)
	{
		$this->valor = $valor;
		return $this;
	}

	/**
	 * Quantidade
	 */
	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade;
		return $this;
	}

	/**
	 * Data de vencimento do boleto
	 */
	public function getDataVencimento()
	{
		return $this->data_vencimento;
	}

	public function setDataVencimento($data_vencimento)
	{
		$this->data_vencimento = $data_vencimento;
		return $this;
	}

	/**
	 * Número do documento
	 */
	public function getDocumento()
	{
		return $this->documento;
	}

	public function setDocumento($documento)
	{
		$this->documento = $documento;
		return $this;
	}

	/**
	 * Data de emissão do boleto
	 */
	public function getDataEmissao()
	{
		return $this->data_emissao;
	}

	public function setDataEmissao($data_emissao)
	{
		$this->data_emissao = $data_emissao;
		return $this;
	}

	/**
	 * Data de processamento do boleto (Opcional)
	 */
	public function getDataProcessamento()
	{
		return $this->data_processamento;
	}

	public function setDataProcessamento($data_processamento)
	{
		$this->data_processamento = $data_processamento;
		return $this;
	}

	/**
	 * O campo Aceite indica se o Pagador (quem recebe o boleto) aceitou o
	 * boleto, ou seja, se ele assinou o documento de cobrança que originou o
	 * boleto
	 */
	public function getAceite()
	{
		return $this->aceite;
	}

	/**
	 * O campo Aceite indica se o Pagador (quem recebe o boleto) aceitou o
	 * boleto, ou seja, se ele assinou o documento de cobrança que originou o
	 * boleto
	 */
	public function isAceite()
	{
		return !is_null($this->aceite) && $this->aceite;
	}

	public function setAceite($aceite)
	{
		if($aceite == 'S' || $aceite == 'Y')
			$aceite = true;
		else if($aceite == 'N')
			$aceite = false;
		$this->aceite = $aceite;
		return $this;
	}

	/**
	 * Espécie do documento
	 */
	public function getEspecieDocumento()
	{
		return $this->especie_documento;
	}

	public function setEspecieDocumento($especie_documento)
	{
		$this->especie_documento = $especie_documento;
		return $this;
	}

	/**
	 * Array de instruções sobre o boleto
	 */
	public function getInstrucoes()
	{
		return $this->instrucoes;
	}

	public function setInstrucoes($instrucoes)
	{
		settype($instrucoes, 'array');
		$this->instrucoes = $instrucoes;
		return $this;
	}

	/**
	 * Banco que processará esse boleto
	 */
	public function getBanco()
	{
		return $this->banco;
	}

	public function setBanco($banco)
	{
		$this->banco = $banco;
		if(!is_null($banco))
			$this->getBanco()->setBoleto($this);
		return $this;
	}

	/**
	 * Cliente que irá pagar esse boleto
	 */
	public function getCliente()
	{
		return $this->cliente;
	}

	public function setCliente($cliente)
	{
		$this->cliente = $cliente;
		return $this;
	}

	/**
	 * Empresa que irá receber o pagamento desse boleto
	 */
	public function getBeneficiario()
	{
		return $this->beneficiario;
	}

	public function setBeneficiario($beneficiario)
	{
		$this->beneficiario = $beneficiario;
		return $this;
	}

	/**
	 * Configuração do boleto
	 */
	public function getConfiguracao()
	{
		return $this->configuracao;
	}

	public function setConfiguracao($configuracao)
	{
		$this->configuracao = $configuracao;
		return $this;
	}

	/**
	 * Formato de geração do boleto: PDF, HTML ou PNG
	 */
	public function getFormato()
	{
		return $this->formato;
	}

	public function setFormato($formato)
	{
		$this->formato = $formato;
		return $this;
	}

	/**
	 * Obtém a quantidade de dias entre a data base e a data de vencimento
	 */
	public function getFatorVencimento($digitos = 4)
	{
		$dias = Utilitario::contaDias(strtotime('1997-10-07'), $this->getDataVencimento());
		$str_dias = strval($dias);
		if(strlen($str_dias) > $digitos)
			$str_dias = '0'; // Extrapolou a quantidade de dígitos do fator
		return Utilitario::padDigit($str_dias, $digitos);
	}

	/**
	 * Retorna as informações do boleto em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$boleto = array();
		$boleto['numero'] = $this->getNumero();
		$boleto['valor'] = $this->getValor();
		$boleto['quantidade'] = $this->getQuantidade();
		$boleto['datavencimento'] = $this->getDataVencimento();
		$boleto['documento'] = $this->getDocumento();
		$boleto['dataemissao'] = $this->getDataEmissao();
		$boleto['dataprocessamento'] = $this->getDataProcessamento();
		$boleto['aceite'] = $this->getAceite();
		$boleto['especiedocumento'] = $this->getEspecieDocumento();
		$boleto['instrucoes'] = $this->getInstrucoes();
		$boleto['banco'] = $this->getBanco();
		$boleto['cliente'] = $this->getCliente();
		$boleto['beneficiario'] = $this->getBeneficiario();
		$boleto['configuracao'] = $this->getConfiguracao();
		$boleto['formato'] = $this->getFormato();
		return $boleto;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Boleto informações do boleto
	 */
	public function fromArray($boleto = array())
	{
		if($boleto instanceof Boleto)
			$boleto = $boleto->toArray();
		else if(!is_array($boleto))
			return $this;
		$this->setNumero($boleto['numero']);
		$this->setValor($boleto['valor']);
		$this->setQuantidade($boleto['quantidade']);
		$this->setDataVencimento($boleto['datavencimento']);
		$this->setDocumento($boleto['documento']);
		$this->setDataEmissao($boleto['dataemissao']);
		$this->setDataProcessamento($boleto['dataprocessamento']);
		$this->setAceite($boleto['aceite']);
		$this->setEspecieDocumento($boleto['especiedocumento']);
		$this->setInstrucoes($boleto['instrucoes']);
		$this->setBanco($boleto['banco']);
		$this->setCliente($boleto['cliente']);
		$this->setBeneficiario($boleto['beneficiario']);
		$this->setConfiguracao($boleto['configuracao']);
		$this->setFormato($boleto['formato']);
		return $this;
	}


	/**
	 * Gera o boleto e retorna o resultado do formato
	 * @return string
	 */
	public function gerar()
	{
		$this->getFormato()->inicia($this);
		return $this->getFormato()->gerar();
	}

}