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
 * Classe base para um tipo de pessoa
 */
abstract class Pessoa
{

	/**
	 * Código do beneficiário
     * @var string
	 */
	private $codigo;

	/**
	 * Código único que identifica a pessoa
     * @var string
	 */
	private $identificador;

	/**
	 * Nome da pessoa
     * @var string
	 */
	private $nome;

	/**
	 * Endereço da pessoa
     * @var string
	 */
	private $endereco;

	public function __construct($pessoa = array())
	{
		$this->fromArray($pessoa);
	}

	/**
	 * Devolve o identificador da pessoa já formatado
	 */
	abstract public function mascararIdentificador();

	/**
	 * Código do beneficiário
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
	 * Código único que identifica a pessoa
	 */
	public function getIdentificador($mascarar = false)
	{
		if($mascarar)
			return $this->mascararIdentificador();
		return $this->identificador;
	}

	public function setIdentificador($identificador)
	{
		$this->identificador = $identificador;
		return $this;
	}

	/**
	 * Nome da pessoa
	 */
	public function getNome()
	{
		return $this->nome;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
		return $this;
	}

	/**
	 * Endereço da pessoa
	 */
	public function getEndereco()
	{
		return $this->endereco;
	}

	public function setEndereco($endereco)
	{
		$this->endereco = $endereco;
		return $this;
	}

	/**
	 * Retorna as informações da pessoa em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$pessoa = array();
		$pessoa['codigo'] = $this->getCodigo();
		$pessoa['identificador'] = $this->getIdentificador();
		$pessoa['nome'] = $this->getNome();
		$pessoa['endereco'] = $this->getEndereco();
		return $pessoa;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Pessoa informações da pessoa
	 */
	public function fromArray($pessoa = array())
	{
		if($pessoa instanceof Pessoa)
			$pessoa = $pessoa->toArray();
		else if(!is_array($pessoa))
			return $this;
		$this->setCodigo($pessoa['codigo']);
		$this->setIdentificador($pessoa['identificador']);
		$this->setNome($pessoa['nome']);
		$this->setEndereco($pessoa['endereco']);
		return $this;
	}

}