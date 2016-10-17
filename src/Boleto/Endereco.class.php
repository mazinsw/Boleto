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
 * Endereço do cliente ou da empresa
 */
class Endereco
{

	const CEP_MASK = '99999-999';

	/**
	 * Número da casa
     * @var string
	 */
	private $numero;

	/**
	 * Nome da rua ou avenida
     * @var string
	 */
	private $logradouro;

	/**
	 * Nome do bairro
     * @var string
	 */
	private $bairro;

	/**
	 * Nome da cidade
     * @var string
	 */
	private $cidade;

	/**
	 * Nome do estado
     * @var string
	 */
	private $estado;

	/**
	 * Nome da unidade deferada
     * @var string
	 */
	private $uf;

	/**
	 * CEP do endereço
     * @var string
	 */
	private $cep;

	/**
	 * Nome do país
     * @var string
	 */
	private $pais;

	public function __construct($endereco = array())
	{
		$this->fromArray($endereco);
	}

	/**
	 * Número da casa
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
	 * Nome da rua ou avenida
	 */
	public function getLogradouro()
	{
		return $this->logradouro;
	}

	public function setLogradouro($logradouro)
	{
		$this->logradouro = $logradouro;
		return $this;
	}

	/**
	 * Nome do bairro
	 */
	public function getBairro()
	{
		return $this->bairro;
	}

	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
		return $this;
	}

	/**
	 * Nome da cidade
	 */
	public function getCidade()
	{
		return $this->cidade;
	}

	public function setCidade($cidade)
	{
		$this->cidade = $cidade;
		return $this;
	}

	/**
	 * Nome do estado
	 */
	public function getEstado()
	{
		return $this->estado;
	}

	public function setEstado($estado)
	{
		$this->estado = $estado;
		return $this;
	}

	/**
	 * Nome da unidade deferada
	 */
	public function getUF()
	{
		return $this->uf;
	}

	public function setUF($uf)
	{
		$this->uf = $uf;
		return $this;
	}

	/**
	 * CEP do endereço
	 */
	public function getCEP($formatar = false)
	{
		if($formatar)
			return Utilitario::mascarar($this->cep, self::CEP_MASK);
		return $this->cep;
	}

	public function setCEP($cep)
	{
		$this->cep = $cep;
		return $this;
	}

	/**
	 * Nome do país
	 */
	public function getPais()
	{
		return $this->pais;
	}

	public function setPais($pais)
	{
		$this->pais = $pais;
		return $this;
	}

	public function getDetalhado()
	{
		return $this->getLogradouro() . ', ' . $this->getNumero() . ' - ' . 
			$this->getCEP(true) . ' - ' . $this->getCidade() . ' / ' . $this->getUF();
	}

	/**
	 * Retorna as informações do endereço em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$endereco = array();
		$endereco['numero'] = $this->getNumero();
		$endereco['logradouro'] = $this->getLogradouro();
		$endereco['bairro'] = $this->getBairro();
		$endereco['cidade'] = $this->getCidade();
		$endereco['estado'] = $this->getEstado();
		$endereco['uf'] = $this->getUF();
		$endereco['cep'] = $this->getCEP();
		$endereco['pais'] = $this->getPais();
		return $endereco;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Endereco informações do endereço
	 */
	public function fromArray($endereco = array())
	{
		if($endereco instanceof Endereco)
			$endereco = $endereco->toArray();
		else if(!is_array($endereco))
			return $this;
		$this->setNumero($endereco['numero']);
		$this->setLogradouro($endereco['logradouro']);
		$this->setBairro($endereco['bairro']);
		$this->setCidade($endereco['cidade']);
		$this->setEstado($endereco['estado']);
		$this->setUF($endereco['uf']);
		$this->setCEP($endereco['cep']);
		$this->setPais($endereco['pais']);
		return $this;
	}

}