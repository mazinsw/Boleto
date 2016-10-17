<?php
/**
 * MIT License
 * 
 * Copyright (c) 2016 MZSW CREATIVE SOFTWARE
 * 
 * @author Rodrigo Araujo <http://codigofonte.uol.com.br/perfil/rlpa>
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
 * Classe que gera um código de barras em PNG, SVG ou RAW
 */
class BarCode
{
	const PNG  = 0;
	const SVG = 1;
	const RAW  = 2;

	const MASK = '99999.99999 99999.999999 99999.999999 9 99999999999999';

	/**
	 * Cadeira de números para gerar o código de barras
     * @var string
	 */
	private $numero;

	/**
	 * Formato de geração do código de barras: PNG, SVG ou RAW
     * @var integer
	 */
	private $formato;

	/**
	 * Altura do código de barras
     * @var integer
	 */
	private $altura;

	/**
	 * Grau de aumento do código de barras
     * @var integer
	 */
	private $zoom;

	public function __construct($numero)
	{
		$this->setNumero($numero);
		$this->setFormato(self::PNG);
		$this->setZoom(1);
		$this->setAltura(50);
	}

	/**
	 * Obtém o número do qual será gerado o código de barras
	 */
	public function getNumero()
	{
		return $this->numero;
	}

	public function setNumero($numero)
	{
		$this->numero = $numero;
		return $this;
	}

	/**
	 * Obtém o formato para a geração do código de barras
	 */
	public function getFormato()
	{
		return $this->formato;
	}

	public function setFormato($formato)
	{
		$this->formato = $formato;
		return $this;
	}

	/**
	 * Obtém a altura em pixel do código de barras
	 */
	public function getAltura()
	{
		return $this->altura;
	}

	public function setAltura($altura)
	{
		$this->altura = $altura;
		return $this;
	}

	/**
	 * Obtém o grau de aumento do código de barras
	 */
	public function getZoom()
	{
		return $this->zoom;
	}

	public function setZoom($zoom)
	{
		$this->zoom = $zoom;
		return $this;
	}

	static private function esquerda($entra, $comp){
		return substr($entra, 0, $comp);
	}

	static private function direita($entra, $comp){
		return substr($entra, strlen($entra) - $comp, $comp);
	}

	private function transformar()
	{
		$barcodes = array();
		$barcodes[0] = '00110';
		$barcodes[1] = '10001';
		$barcodes[2] = '01001';
		$barcodes[3] = '11000';
		$barcodes[4] = '00101';
		$barcodes[5] = '10100';
		$barcodes[6] = '01100';
		$barcodes[7] = '00011';
		$barcodes[8] = '10010';
		$barcodes[9] = '01010';
		$fino = 1 * $this->zoom;
		$largo = 3 * $this->zoom;
		for($f1 = 9; $f1 >= 0; $f1--){
			for($f2 = 9; $f2 >= 0; $f2--){
				$f = ($f1 * 10) + $f2 ;
				$texto = '';
				for( $i = 1; $i < 6; $i++){
					$texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
				}
				$barcodes[$f] = $texto;
			}
		}
		$texto = $this->getNumero();
		if((strlen($texto) % 2) <> 0){
			$texto = '0' . $texto;
		}
		$lines = array();
		$lines[] = array('width' => $fino, 'color' => '#000');
		$lines[] = array('width' => $fino, 'color' => '#fff');
		$lines[] = array('width' => $fino, 'color' => '#000');
		$lines[] = array('width' => $fino, 'color' => '#fff');
		while (strlen($texto) > 0) {
			$i = round(self::esquerda($texto, 2));
			$texto = self::direita($texto, strlen($texto) - 2);
			$f = $barcodes[$i];
			for($i = 1; $i < 11; $i += 2){
				if(substr($f, ($i - 1), 1) == '0') {
					$f1 = $fino;
				} else {
					$f1 = $largo;
				}
				$lines[] = array('width' => $f1, 'color' => '#000');
				if(substr($f, $i, 1) == '0') {
					$f2 = $fino;
				} else {
					$f2 = $largo;
				}
				$lines[] = array('width' => $f2, 'color' => '#fff');
			}
		}
		$lines[] = array('width' => $largo, 'color' => '#000');
		$lines[] = array('width' => $fino, 'color' => '#fff');
		$lines[] = array('width' => $fino, 'color' => '#000');
		return $lines;
	}

	/**
	 * Exporta as linhas para uma imagem PNG
	 * @return string
	 */
	private function exportarPNG($lines)
	{
		$largura = 0;
		foreach ($lines as $value) {
			$largura += $value['width'];
		}
		$im = imagecreatetruecolor($largura, $this->getAltura());
		$white = imagecolorallocate($im, 255, 255, 255);
		$black = imagecolorallocate($im, 0, 0, 0);
		$x = 0;
		foreach ($lines as $value) {
			$color = $black;
			if($value['color'] == '#fff')
				$color = $white;
			imagefilledrectangle($im, $x, 0, $x + $value['width'], $this->getAltura() - 1, $color);
			$x += $value['width'];
		}
		// Save the image
		ob_start();
		imagepng($im);
		$data = ob_get_clean();
		imagedestroy($im);
		return $data;
	}

	/**
	 * Exporta as linhas para código SVG
	 * @return string
	 */
	private function exportarSVG($lines)
	{
		$result  = '';
		$x = 0;
		foreach ($lines as $value) {
			if($value['color'] != '#fff')
				$result .= '<rect x="'.$x.'" y="0" width="'.$value['width'].'" height="'.$this->getAltura().'" />';
			$x += $value['width'];
		}
		$result = '<svg width="'.$x.'" height="'.$this->getAltura().'">'.$result.'</svg>';
		return $result;
	}

	/**
	 * Gera um código de barras com o número e formato informado
	 * @return string
	 */
	public function gerar($formato = null)
	{
		if(is_null($formato))
			$formato = $this->getFormato();
		$lines = $this->transformar();
		switch ($formato) {
			case BarCode::PNG:
				return $this->exportarPNG($lines);
			case BarCode::SVG:
				return $this->exportarSVG($lines);
			default:
				return $lines;
		}
	}

	public function formatar()
	{
		return Utilitario::mascarar($this->getNumero(), self::MASK);
	}

}