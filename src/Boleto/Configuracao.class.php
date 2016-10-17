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
 * Classe de configuração do boleto
 */
class Configuracao
{

	/**
	 * Pasta onde o arquivo css se encontra
     * @var string
	 */
	private $estilo_caminho;

	/**
	 * Pasta onde se encontra as imagens das logomarcas dos bancos
     * @var string
	 */
	private $imagem_caminho;

	/**
	 * Obtém o caminho completo do arquivo de modelo de boleto
     * @var string
	 */
	private $modelo_arquivo;

	/**
	 * Símbolo da moeda utiliza
     * @var string
	 */
	private $especie;

	public function __construct($configuracao = array())
	{
		if(!($configuracao instanceof Configuracao) && empty($configuracao)) {
			$configuracao = array(
				'estilocaminho' => dirname(dirname(dirname(__FILE__))) . '/static/css',
				'imagemcaminho' => dirname(dirname(dirname(__FILE__))) . '/static/img',
				'modeloarquivo' => dirname(dirname(__FILE__)) . '/template/boleto.html',
				'especie' => 'R$',
			);
		}
		$this->fromArray($configuracao);
	}

	/**
	 * Obtém o estilo CSS em texto para utilizar na exportação para HTML
	 */
	public function getEstilo()
	{
		return file_get_contents($this->getEstiloCaminho() . '/boleto.css');
	}

	/**
	 * Pasta onde o arquivo css se encontra
	 */
	public function getEstiloCaminho()
	{
		return $this->estilo_caminho;
	}

	public function setEstiloCaminho($estilo_caminho)
	{
		$this->estilo_caminho = $estilo_caminho;
		return $this;
	}

	/**
	 * Obtém o estilo CSS em texto para utilizar na exportação para HTML
	 */
	public function getImagem($image_name)
	{
		return file_get_contents($this->getImagemCaminho($image_name));
	}

	/**
	 * Pasta onde se encontra as imagens das logomarcas dos bancos
	 */
	public function getImagemCaminho($image_name = null)
	{
		if(is_null($image_name))
			return $this->imagem_caminho;
		return $this->imagem_caminho . '/' . $image_name;
	}

	public function setImagemCaminho($imagem_caminho)
	{
		$this->imagem_caminho = $imagem_caminho;
		return $this;
	}

	/**
	 * Obtém o caminho completo do arquivo de modelo de boleto
	 */
	public function getModeloArquivo($codigo_banco = null)
	{
		return $this->modelo_arquivo;
	}

	public function setModeloArquivo($modelo_arquivo)
	{
		$this->modelo_arquivo = $modelo_arquivo;
		return $this;
	}

	/**
	 * Símbolo da moeda utiliza
	 */
	public function getEspecie()
	{
		return $this->especie;
	}

	public function setEspecie($especie)
	{
		$this->especie = $especie;
		return $this;
	}

	/**
	 * Retorna as informações da configuração em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$configuracao = array();
		$configuracao['estilocaminho'] = $this->getEstiloCaminho();
		$configuracao['imagemcaminho'] = $this->getImagemCaminho();
		$configuracao['modeloarquivo'] = $this->getModeloArquivo();
		$configuracao['especie'] = $this->getEspecie();
		return $configuracao;
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|Configuracao informações da configuração
	 */
	public function fromArray($configuracao = array())
	{
		if($configuracao instanceof Configuracao)
			$configuracao = $configuracao->toArray();
		else if(!is_array($configuracao))
			return $this;
		$this->setEstiloCaminho($configuracao['estilocaminho']);
		$this->setImagemCaminho($configuracao['imagemcaminho']);
		$this->setModeloArquivo($configuracao['modeloarquivo']);
		$this->setEspecie($configuracao['especie']);
		return $this;
	}

}