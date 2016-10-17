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
namespace $[Table.style];

$[field.each(all)]
$[field.if(enum)]

class $[Table.norm]$[Field.norm] 
{
$[field.each(option)]
	const $[FIELD.option.norm] = '$[field.option]';
$[field.end]
}
$[field.end]
$[field.end]

$[table.if(comment)]
/**
$[table.each(comment)]
 * $[Table.comment]
$[table.end]
 */
$[table.end]
class $[Table.norm]
{

$[field.each(all)]
$[field.if(comment)]
	/**
$[field.each(comment)]
	 * $[Field.comment]
$[field.end]
     * @var string
	 */
$[field.end]
	private $$[field.unix];

$[field.end]
	public function __construct($$[table.unix] = array())
	{
		$this->fromArray($$[table.unix]);
	}
$[field.each(all)]

$[field.if(comment)]
	/**
$[field.each(comment)]
	 * $[Field.comment]
$[field.end]
	 */
$[field.end]
	public function get$[Field.norm]()
	{
		return $this->$[field.unix];
	}
$[field.if(boolean)]

$[field.if(comment)]
	/**
$[field.each(comment)]
	 * $[Field.comment]
$[field.end]
	 */
$[field.end]
	public function is$[Field.norm]()
	{
		return $this->$[field.unix] === true || $this->$[field.unix] == 'Y';
	}
$[field.end]

	public function set$[Field.norm]($$[field.unix])
	{
		$this->$[field.unix] = $$[field.unix];
		return $this;
	}
$[field.end]

	/**
	 * Retorna as informações d$[table.gender] $[table.name] em forma de array
	 *
	 * @return array
	 */
	public function toArray()
	{
		$$[table.unix] = array();
$[field.each(all)]
		$$[table.unix]['$[field]'] = $this->get$[Field.norm]();
$[field.end]
		return $$[table.unix];
	}

	/**
	 * Atribui os valores de uma instância ou array à essa instância
	 * @var array|$[Table.norm] informações d$[table.gender] $[table.name]
	 */
	public function fromArray($$[table.unix] = array())
	{
		if($$[table.unix] instanceof $[Table.norm])
			$$[table.unix] = $$[table.unix]->toArray();
		else if(!is_array($$[table.unix]))
			return $this;
$[field.each(all)]
		$this->set$[Field.norm]($$[table.unix]['$[field]']);
$[field.end]
		return $this;
	}

}