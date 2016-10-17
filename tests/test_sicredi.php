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
require_once(dirname(dirname(__FILE__)) . '/src/Boleto/autoload.php');


use Boleto\Banco\Sicredi;
use Boleto\Formato\HTML;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);

$carteira = new Carteira();
$carteira->setCodigo('03-19');
$carteira->setAgencia('4042');

$banco = new Sicredi();
$banco->setPosto('18');
$banco->setCarteira($carteira);

$formato = new HTML();

$endereco = new Endereco();
$endereco->setLogradouro('Av. Dos Navegantes');
$endereco->setNumero('123');
$endereco->setCEP('64008-700');
$endereco->setCidade('Teresina');
$endereco->setUF('PI');

$beneficiario = new Empresa();
$beneficiario->setCodigo('61900');
$beneficiario->setNome('Minha Empresa LTDA');
$beneficiario->setCNPJ('52834351000100');

$cliente = new Cliente();
$cliente->setNome('Fulano da Silva');
$cliente->setCPF('48224257703');
$cliente->setEndereco($endereco);

$boleto = new Boleto();
$boleto->setBeneficiario($beneficiario);
$boleto->setCliente($cliente);
$boleto->setQuantidade(1);
$boleto->setNumero('00111');
$boleto->setDocumento('00111');
$boleto->setBanco($banco);
$boleto->setValor(11135.00);
$boleto->setDataEmissao(strtotime('2008-02-01'));
$boleto->setDataVencimento(strtotime('2008-02-01'));
$boleto->setAceite(false);
$boleto->setEspecieDocumento('A');
$boleto->setFormato($formato);
$boleto->setInstrucoes(array(
	'Pagável na rede bancária até a data de vencimento.',
	'Juros de mora de 2.0% mensal(R$ 0,09 ao dia)',
	'DESCONTO DE R$ 29,50 APÓS 03/01/2008 ATÉ 15/01/2008',
	'NÃO RECEBER APÓS 01/02/2008',
	'Após vencimento pagável somente nas Cooperativas do Sicredi',
	'ACRESCER R$ 4,00 REFERENTE AO BOLETO BANCÁRIO',
));

echo $boleto->gerar();