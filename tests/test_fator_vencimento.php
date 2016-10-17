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


error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);

$boleto = new Boleto();
$boleto->setDataVencimento(strtotime('2007-12-20'));
if($boleto->getFatorVencimento() !== '3726')
	throw new Exception('Fator de vencimento '.$boleto->getFatorVencimento().' inválido para a data '.date('d/m/Y', $boleto->setDataVencimento));
echo $boleto->getFatorVencimento()."\n";
$boleto->setDataVencimento(strtotime('2000-07-03'));
if($boleto->getFatorVencimento() !== '1000')
	throw new Exception('Fator de vencimento '.$boleto->getFatorVencimento().' inválido para a data '.date('d/m/Y', $boleto->setDataVencimento));
echo $boleto->getFatorVencimento()."\n";
$boleto->setDataVencimento(strtotime('2000-07-05'));
if($boleto->getFatorVencimento() !== '1002')
	throw new Exception('Fator de vencimento '.$boleto->getFatorVencimento().' inválido para a data '.date('d/m/Y', $boleto->setDataVencimento));
echo $boleto->getFatorVencimento()."\n";
$boleto->setDataVencimento(strtotime('2002-05-01'));
if($boleto->getFatorVencimento() !== '1667')
	throw new Exception('Fator de vencimento '.$boleto->getFatorVencimento().' inválido para a data '.date('d/m/Y', $boleto->setDataVencimento));
echo $boleto->getFatorVencimento()."\n";
$boleto->setDataVencimento(strtotime('2010-11-17'));
if($boleto->getFatorVencimento() !== '4789')
	throw new Exception('Fator de vencimento '.$boleto->getFatorVencimento().' inválido para a data '.date('d/m/Y', $boleto->setDataVencimento));
echo $boleto->getFatorVencimento()."\n";
$boleto->setDataVencimento(strtotime('2025-02-21'));
if($boleto->getFatorVencimento() !== '9999')
	throw new Exception('Fator de vencimento '.$boleto->getFatorVencimento().' inválido para a data '.date('d/m/Y', $boleto->setDataVencimento));
echo $boleto->getFatorVencimento()."\n";
$boleto->setDataVencimento(strtotime('2025-02-26'));
if($boleto->getFatorVencimento() !== '0000')
	throw new Exception('Fator de vencimento '.$boleto->getFatorVencimento().' inválido para a data '.date('d/m/Y', $boleto->setDataVencimento));
echo $boleto->getFatorVencimento()."\n";
