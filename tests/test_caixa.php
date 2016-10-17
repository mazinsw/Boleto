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


use Boleto\Banco\Caixa;
use Boleto\Formato\HTML;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);

$carteira = new Carteira();
$carteira->setCodigo('24-16');
$carteira->setAgencia('4042');

$banco = new Caixa();
$banco->setCarteira($carteira);

$formato = new HTML();

$endereco = new Endereco();
$endereco->setLogradouro('Av. Avenida principal');
$endereco->setNumero('125');
$endereco->setCEP('640200250');
$endereco->setCidade('Teresina');
$endereco->setUF('PI');

$beneficiario = new Cliente();
$beneficiario->setCodigo('100000-4');
$beneficiario->setNome('Minha Empresa LTDA');
$beneficiario->setCPF('91871815762');

$cliente = new Cliente();
$cliente->setNome('Fulano da Silva');
$cliente->setCPF('18364348558');
$cliente->setEndereco($endereco);

$boleto = new Boleto();
$boleto->setBeneficiario($beneficiario);
$boleto->setCliente($cliente);
$boleto->setQuantidade(1);
$boleto->setNumero('24000000000000111-6');
$boleto->setDocumento('0012300');
$boleto->setBanco($banco);
$boleto->setValor(11135.00);
$boleto->setDataEmissao(strtotime('2008-02-01'));
$boleto->setDataVencimento(strtotime('2008-02-01'));
$boleto->setDataProcessamento(strtotime('2008-02-06'));
$boleto->setAceite(true);
$boleto->setEspecieDocumento('DM');
$boleto->setFormato($formato);
$boleto->setInstrucoes(array(
	'Pagável na rede bancária até a data de vencimento.',
	'Juros de mora de 2.0% mensal(R$ 0,09 ao dia)',
	'Após vencimento pagável somente nas agências da Caixa',
	'ACRESCER R$ 4,00 REFERENTE AO BOLETO BANCÁRIO',
));

echo $boleto->gerar();