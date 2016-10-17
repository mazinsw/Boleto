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


/**
 * Carteira que estende de uma empresa
 */
class Carteira
{

	/**
	 * Código da carteira
     * @var string
	 */
	private $codigo;

	/**
	 * Código da agência do banco
     * @var string
	 */
	private $agencia;

	/**
	 * Número da conta do banco
     * @var string
	 */
	private $conta;

	public function __construct($carteira = array())
	{
		$this->fromArray($carteira);
	}

	/**
	 * Código da carteira
	 */
	public function getCodigo()
	{
		return $this->codigo;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
		return $this;
	}

	/**
	 * Código da agência do banco
	 */
	public function getAgencia()
	{
		return $this->agencia;
	}

	public function setAgencia($agencia)
	{
		$this->agencia = $agencia;
		return $this;
	}

	/**
	 * Número da conta do banco
	 */
	public function getConta()
	{
		return $this->conta;
	}

	public function setConta($conta)
	{
		$this->conta = $conta;
		return $this;
	}

	/**
	 * Retorna as informações da carteira em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$carteira = array();
		$carteira['codigo'] = $this->getCodigo();
		$carteira['agencia'] = $this->getAgencia();
		$carteira['conta'] = $this->getConta();
		return $carteira;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Carteira informações da carteira
	 */
	public function fromArray($carteira = array())
	{
		if($carteira instanceof Carteira)
			$carteira = $carteira->toArray();
		else if(!is_array($carteira))
			return $this;
		$this->setCodigo($carteira['codigo']);
		$this->setAgencia($carteira['agencia']);
		$this->setConta($carteira['conta']);
		return $this;
	}

}