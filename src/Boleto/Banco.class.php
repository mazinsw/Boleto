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
use Boleto\Util\BarCode;

/**
 * Banco que estende de uma carteira e implementa um retorno
 */
abstract class Banco extends Empresa implements RetornoInterface, RemessaInterface
{

	/**
	 * Nome do arquivo de imagem da logomarca do banco
     * @var string
	 */
	private $logo;

	/**
	 * Carteira do beneficiário no banco
     * @var Carteira
	 */
	private $carteira;

	/**
	 * Boleto que está sendo gerado
     * @var string
	 */
	private $boleto;

	public function __construct($banco = array())
	{
		$this->fromArray($banco);
	}

	/**
	 * Nome do arquivo de imagem da logomarca do banco
	 */
	public function getLogo()
	{
		return $this->logo;
	}

	public function setLogo($logo)
	{
		$this->logo = $logo;
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
	 * Carteira do beneficiário no banco
	 */
	public function getCarteira()
	{
		return $this->carteira;
	}

	public function setCarteira($carteira)
	{
		$this->carteira = $carteira;
		return $this;
	}

	/**
	 * Boleto que está sendo gerado
	 */
	public function getBoleto()
	{
		return $this->boleto;
	}

	public function setBoleto($boleto)
	{
		$this->boleto = $boleto;
		return $this;
	}

	/**
	 * Configuração do boleto
	 */
	public function getConfiguracao()
	{
		return $this->getBoleto()->getConfiguracao();
	}

	/**
	 * Obtém o código do banco com o dígito verificador já formatado
	 */
	public function getCodigoVerificado()
	{
		return $this->getCodigo() . '-' . $this->getDigitoVerificador();
	}

	/**
	 * Obtém o código da agência com o código do beneficiário
	 */
	public function getAgenciaCodigo()
	{
		return $this->getCarteira()->getAgencia() . ' / ' . 
			$this->getBoleto()->getBeneficiario()->getCodigo();
	}

	/**
	 * Obtém o código Nosso número já processado
	 */
	public function getNossoNumero($formatar = false)
	{
		// Considera o nosso número já informado formatado
		$nosso_numero = $this->getBoleto()->getNumero();
		if(!$formatar)
			$nosso_numero = Utilitario::getDigitos($nosso_numero);
		return $nosso_numero;
	}

	/**
	 * Calcula o código da linha digitável
	 */
	public function getLinhaDigitavel($formatado = false)
	{
		$linha = $this->getCodigoBarras();
		if(!$formatado)
			return $linha;
		return Utilitario::mascarar($linha, BarCode::MASK);
	}

	/**
	 * Obtém o texto exibido no aceite
	 */
	public function getAceite()
	{
		return $this->getBoleto()->isAceite()?'S':'N';
	}

	/**
	 * Obtém o local de pagamento
	 */
	public function getLocalPagamento()
	{
		return 'PREFERENCIALMENTE EM CASAS LOTÉRICAS ATÉ O VALOR LIMITE';
	}

	/**
	 * Obtém o local de pagamento
	 */
	public function getTitulo()
	{
		return 'Boleto '.$this->getFantasia();
	}

	/**
	 * Calcula o código de barras através das informações do boleto
	 */
	abstract public function getCodigoBarras();

	/**
	 * Obtém o dígito verificador do banco
	 */
	abstract public function getDigitoVerificador();

	/**
	 * Retorna as informações do banco em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$banco = parent::toArray();
		$banco['logo'] = $this->getLogo();
		$banco['carteira'] = $this->getCarteira();
		$banco['boleto'] = $this->getBoleto();
		return $banco;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Banco informações do banco
	 */
	public function fromArray($banco = array())
	{
		if($banco instanceof Banco)
			$banco = $banco->toArray();
		else if(!is_array($banco))
			return $this;
		parent::fromArray($banco);
		$this->setLogo($banco['logo']);
		$this->setCarteira($banco['carteira']);
		$this->setBoleto($banco['boleto']);
		return $this;
	}

}