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
 * Empresa beneficiária ou cliente pessoa jurídica
 */
class Empresa extends Pessoa
{
	const CNPJ_MASK = '99.999.999/9999-99';

	/**
	 * Nome fantasia da empresa
     * @var string
	 */
	private $fantasia;

	public function __construct($empresa = array())
	{
		$this->fromArray($empresa);
	}

	/**
	 * Devolve o identificador da pessoa já formatado
	 */
	public function mascararIdentificador()
	{
		return Utilitario::mascarar($this->getCNPJ(), self::CNPJ_MASK);
	}

	/**
	 * Nome fantasia da empresa
	 */
	public function getFantasia()
	{
		return $this->fantasia;
	}

	public function setFantasia($fantasia)
	{
		$this->fantasia = $fantasia;
		return $this;
	}

	/**
	 * Código nacional de pessoa jurídica
	 */
	public function getCNPJ()
	{
		return $this->getIdentificador();
	}

	public function setCNPJ($cnpj)
	{
		return $this->setIdentificador($cnpj);
	}

	/**
	 * Retorna as informações da empresa em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$empresa = parent::toArray();
		$empresa['fantasia'] = $this->getFantasia();
		return $empresa;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Empresa informações da empresa
	 */
	public function fromArray($empresa = array())
	{
		if($empresa instanceof Empresa)
			$empresa = $empresa->toArray();
		else if(!is_array($empresa))
			return $this;
		parent::fromArray($empresa);
		$this->setFantasia($empresa['fantasia']);
		return $this;
	}

}