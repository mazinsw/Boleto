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
namespace Boleto\Formato;

use Boleto\Formato;
use Boleto\Cliente;
use Boleto\Empresa;
use Boleto\Util\BarCode;
use Boleto\Util\Utilitario;

/**
 * Classe abstrata de formato para de geração do boleto
 */
class HTML extends Formato
{

	/**
	 * Escreve a logo e o número do código de barras
	 */
	public function escreveCabecalho() {}

	/**
	 * Escreve o demonstrativo do boleto
	 */
	public function escreveDemonstrativo() {}

	/**
	 * Escreve um separador para corte
	 */
	public function escreveSeparador() {}

	/**
	 * Escreve a ficha contendo todos os dados do boleto
	 */
	public function escreveFicha() {}

	/**
	 * Escreve a imagem do código de barras do boleto
	 */
	public function escreveCodigoBarras() {}


	private function base64Image($type, $data)
	{
		return 'data:image/' . $type . ';base64,' . base64_encode($data);
	}

	private function dataImage($nome)
	{
		$path = $this->getConfiguracao()->getImagemCaminho($nome);
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		return $this->base64Image($type, $data);
	}

	/**
	 * Gera o boleto no formato HTML
	 */
	public function gerar($boleto = null)
	{
		parent::gerar($boleto);
		$titulo = $this->getBanco()->getTitulo();
		$local_pagamento = $this->getBanco()->getLocalPagamento();
		$beneficiario = $this->getBeneficiario();
		$beneficiario_nome = $beneficiario->getNome();
		$estilo = $this->getConfiguracao()->getEstilo();
		$logo_embutido = $this->dataImage($this->getBanco()->getLogo());
		$tesoura_embutida = $this->dataImage('tesoura.png');
		$barcode = new BarCode($this->getBanco()->getCodigoBarras());
		$codbarras_svg = $barcode->gerar(BarCode::SVG);
		$linha_digitavel = $this->getBanco()->getLinhaDigitavel(true);
		$verificador = $this->getBanco()->getCodigoVerificado();
		$banco_fantasia = $this->getBanco()->getFantasia();
		$agencia_codigo = $this->getBanco()->getAgenciaCodigo();
		$especie = $this->getConfiguracao()->getEspecie();
		$quantidade = $this->getBoleto()->getQuantidade();
		$nosso_numero = $this->getBanco()->getNossoNumero(true);
		$numero_documento = $this->getBoleto()->getDocumento();
		$cpf_cnpj_cli = $this->getBoleto()->getCliente()->getIdentificador(true);
		$vencimento = date('d/m/Y', $this->getBoleto()->getDataVencimento());
		$valor_documento = Utilitario::formatarMoeda($this->getBoleto()->getValor());
		$cliente_id_title = 'CPF';
		if($beneficiario instanceof Empresa)
			$cliente_id_title = 'CNPJ';
		$cliente_nome_cpf = $this->getBoleto()->getCliente()->getNome();
		if(!is_null($cpf_cnpj_cli))
			$cliente_nome_cpf .= ' - ' . $cliente_id_title . ': ' . $cpf_cnpj_cli;
		$_endereco = $this->getBoleto()->getCliente()->getEndereco();
		$cliente_endereco = '';
		if(!is_null($_endereco))
			$cliente_endereco = $_endereco->getDetalhado();
		$data_documento = date('d/m/Y', $this->getBoleto()->getDataEmissao());
		$data_processamento = $this->getBoleto()->getDataProcessamento();
		if(!is_null($data_processamento))
			$data_processamento = date('d/m/Y', $data_processamento);
		$especie_doc = $this->getBoleto()->getEspecieDocumento();
		$aceite = $this->getBanco()->getAceite();
		$carteira = $this->getBanco()->getCarteira()->getCodigo();
		$instrucoes = $this->getBoleto()->getInstrucoes();
		$sacador_avalista = $beneficiario->getNome();
		$cpf_cnpj_title = 'CNPJ';
		if($beneficiario instanceof Cliente)
			$cpf_cnpj_title = 'CPF';
		$cpf_cnpj = $beneficiario->getIdentificador(true);
		if(!is_null($cpf_cnpj))
			$sacador_avalista .= ' - ' . $cpf_cnpj_title . ': ' . $cpf_cnpj;
		ob_start();
		include $this->getConfiguracao()->getModeloArquivo($this->getBanco()->getCodigo());
		return ob_get_clean();
	}

}