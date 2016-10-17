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
namespace Boleto\Util;


/**
 * Carteira que estende de uma empresa
 */
class Utilitario
{

	static public function mascarar($str, $mask)
	{
		if(empty($str))
			return null;
		$len = strlen($mask);
		$res = '';
		$j = 0;
		$opt = false;
		for ($i=0; $i < $len; $i++) {
			if($mask[$i] == '9' || $mask[$i] == '0')
				$res .= $str[$j++];
			else if($mask[$i] == '?')
				$opt = true;
			else
				$res .= $mask[$i];
		}
		return $res;
	}

	static public function formatarMoeda($valor)
	{
		$k = round($valor, 2);
		return number_format($k, 2, ',', '.');
	}

	/**
	 * retorna apenas os números da string
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	static public function getDigitos($str)
	{
		return preg_replace('/[^0-9]/', '', $str);
	}

	static public function contaDias($date_begin, $date_end)
	{
		$date_end = strtotime(date('H:i:s', $date_begin), $date_end);
		return floor(($date_end - $date_begin) / (60 * 60 * 24));
	}

	static public function padDigit($text, $len, $digit = '0')
	{
		return str_pad($text, $len, $digit, STR_PAD_LEFT);
	}

	static public function padMoeda($valor, $len, $digit = '0')
	{
		$text = self::formatarMoeda($valor);
		$text = self::getDigitos($text);
		return str_pad($text, $len, $digit, STR_PAD_LEFT);
	}

	/**
	 * Retorna o módulo dos dígitos por 11
	 *
	 * @param string $digitos
	 *
	 * @return int
	 */
	static public function getModulo11($digitos)
	{
		$sum = 0;
		$mul = 1;
		$len = strlen($digitos);
		for ($i = $len - 1; $i >= 0; $i--) { 
			$mul++;
			$dig = $digitos[$i];
			$sum += $dig * $mul;
			if($mul == 9)
				$mul = 1; // reset
		}
		return $sum % 11;
	}

	/**
	 * Retorna o módulo dos dígitos por 10
	 *
	 * @param string $digitos
	 *
	 * @return int
	 */
	static public function getModulo10($digitos)
	{
		$sum = 0;
		$mul = 1;
		$len = strlen($digitos);
		for ($i = $len - 1; $i >= 0; $i--) { 
			$mul++;
			$dig = $digitos[$i];
			$term = $dig * $mul;
			$sum += ($dig == 9)?$dig:($term % 9);
			if($mul == 2)
				$mul = 0; // reset
		}
		return $sum % 10;
	}

	/**
	 * Retorna o Dígito de Auto-Conferência dos dígitos
	 *
	 * @param string $digitos
	 * @param int $div Número divisor que determinará o resto da divisão
	 * @param int $presente Informa o número padrão para substituição do excesso
	 *
	 * @return int
	 */
	static public function getDAC($digitos, $div, $presente = 0)
	{
		$ext = $div % 10;
		if($div == 10)
			$ret = self::getModulo10($digitos);
		else
			$ret = self::getModulo11($digitos);
		return ($ret <= $ext)? $presente: ($div - $ret);
	}

}