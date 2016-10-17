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

/**
 * Banco que estende de uma carteira e implementa um retorno
 */
class Caixa extends Banco
{
	public function __construct($caixa = array())
	{
		$this->fromArray($caixa);
		$this->setCodigo('104');
		$this->setLogo('caixa.png');
		$this->setFantasia('Caixa');
		$this->setNome('Caixa Econômica Federal');
	}

	/**
	 * Calcula o código de barras através das informações do boleto
	 */
	public function getCodigoBarras()
	{
		// TODO: implementar geração de código de barras
		return '03399704101600003831132733701026769500000005100';
	}

	/**
	 * Obtém o dígito verificador do banco
	 */
	public function getDigitoVerificador()
	{
		return Utilitario::getDAC($this->getCodigo(), 11);
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

}