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
 * Classe abstrata de formato para de geração do boleto
 */
abstract class Formato
{
	/**
	 * Salva a referência para o boleto
     * @var Boleto
	 */
	private $boleto;

	/**
	 * Inicia o formato com o boleto a ser gerado
	 */
	public function inicia($boleto)
	{
		$this->boleto = $boleto;
	}

	/**
	 * Banco que processará esse boleto
	 */
	protected function getBanco()
	{
		return $this->getBoleto()->getBanco();
	}

	/**
	 * Obtém o boleto a ser gerado
	 */
	protected function getBoleto()
	{
		return $this->boleto;
	}

	/**
	 * Configuração do boleto
	 */
	protected function getConfiguracao()
	{
		return $this->getBoleto()->getConfiguracao();
	}

	/**
	 * Empresa ou Pessoa que irá receber o pagamento desse boleto
	 */
	public function getBeneficiario()
	{
		return $this->getBoleto()->getBeneficiario();
	}

	/**
	 * Escreve a logo e o número do código de barras
	 */
	abstract public function escreveCabecalho();

	/**
	 * Escreve o demonstrativo do boleto
	 */
	abstract public function escreveDemonstrativo();

	/**
	 * Escreve um separador para corte
	 */
	abstract public function escreveSeparador();

	/**
	 * Escreve a ficha contendo todos os dados do boleto
	 */
	abstract public function escreveFicha();

	/**
	 * Escreve a imagem do código de barras do boleto
	 */
	abstract public function escreveCodigoBarras();

	/**
	 * Gera o boleto com todas as informações
	 */
	public function gerar($boleto = null)
	{
		if(!is_null($banco))
			$this->boleto = $boleto;
		$this->escreveCabecalho();
		$this->escreveDemonstrativo();
		$this->escreveSeparador();
		$this->escreveCabecalho();
		$this->escreveFicha();
		$this->escreveCodigoBarras();
		$this->escreveSeparador();
	}

}