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
 * Cliente pagador pessoa física
 */
class Cliente extends Pessoa
{
	const CPF_MASK = '999.999.999-99';

	public function __construct($cliente = array())
	{
		$this->fromArray($cliente);
	}

	/**
	 * Devolve o identificador da pessoa já formatado
	 */
	public function mascararIdentificador()
	{
		return Utilitario::mascarar($this->getCPF(), self::CPF_MASK);
	}

	/**
	 * Código de identificação do cliente no cadastro de pessoa física
	 */
	public function getCPF()
	{
		return $this->getIdentificador();
	}

	public function setCPF($cpf)
	{
		return $this->setIdentificador($cpf);
	}

	/**
	 * Retorna as informações do cliente em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$cliente = parent::toArray();
		return $cliente;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Cliente informações do cliente
	 */
	public function fromArray($cliente = array())
	{
		if($cliente instanceof Cliente)
			$cliente = $cliente->toArray();
		else if(!is_array($cliente))
			return $this;
		parent::fromArray($cliente);
		return $this;
	}

}