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
 * Classe de retorno que estende de um boleto e possui informações de
 * processamento do boleto
 */
class Retorno extends Boleto
{

	/**
	 * Data de pagamento do boleto
     * @var string
	 */
	private $data_pagamento;

	public function __construct($retorno = array())
	{
		$this->fromArray($retorno);
	}

	/**
	 * Data de pagamento do boleto
	 */
	public function getDataPagamento()
	{
		return $this->data_pagamento;
	}

	public function setDataPagamento($data_pagamento)
	{
		$this->data_pagamento = $data_pagamento;
		return $this;
	}

	/**
	 * Retorna as informações do retorno em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$retorno = parent::toArray();
		$retorno['datapagamento'] = $this->getDataPagamento();
		return $retorno;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Retorno informações do retorno
	 */
	public function fromArray($retorno = array())
	{
		if($retorno instanceof Retorno)
			$retorno = $retorno->toArray();
		else if(!is_array($retorno))
			return $this;
		parent::fromArray($retorno);
		$this->setDataPagamento($retorno['datapagamento']);
		return $this;
	}

}