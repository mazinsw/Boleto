## Geração e Processamento de Boletos (Beta)

###### Essa biblioteca permite a geração de boleto de diversos bancos no formato HTML, PDF e PNG

### Vantagens
- Código bem estruturado e bem reaproveitado que permite a fácil manutenção
- Estrutura de suporte para vários bancos, formatos de geração e modelos de leiaute
- Fácil geração de remessa e importação de arquivo de retorno
- Algoritmos otimizados, alta performance na geração em massa de boleto
- Permite a geração embutida em página de site ou envio por E-mail
- Não escreve nenhum arquivo temporário nas pastas do servidor
- Código de barras em diversos formatos (SVG, PNG e RAW)

### Motivo do projeto
As biliotecas de código aberto encontradas até o momento (2016) não fornecem uma estrutura sólida e com suporte aos arquivos de remessa e retorno, dessa forma surgiu a necessidade de criar uma bilioteca capaz de gerar boletos em diversos formatos, com leiaute customizável, que suporte a geração do arquivo de remessa e importação do arquivo de retorno 

### Ideia do projeto
A ideia é criar uma bilioteca em que os bancos herdam de uma implementação genérica de banco definida pelo Febraban e dessa forma implementam apenas as particularidades de cada instituição, na geração do arquivo de remessa os boletos são passados para uma função que devolve o conteúdo do arquivo de remessa já no formato suportado pelo banco e na importação do arquivo de retorno uma função retornará uma lista de boletos com os status de pagamento (Data de pagamento, Valor pago, Forma de pagamento)

### Expansão do projeto
Como o projeto é grande, precisamos da colaboração de desenvolvedores para melhoria do projeto, para isso envie suas implementações para o E-mail: suporte@mzsw.com.br

### Outras biblioteca
Segue na lista abaixo outras billiotecas para geração de boleto em que algumas delas este projeto se baseia
- BR Cobrança - https://github.com/kivanio/brcobranca
- Boleto PHP - https://github.com/CobreGratis/boletophp
- Py Boleto - https://github.com/eduardocereto/pyboleto
- Boleto Bancário - https://github.com/tomas-stefano/boleto_bancario
 
### Exemplo básico de geração de boleto
```
$carteira = new Carteira();
$carteira->setCodigo('03-19');
$carteira->setAgencia('4042');

$banco = new Sicredi();
$banco->setPosto('18');
$banco->setCarteira($carteira);

$beneficiario = new Empresa();
$beneficiario->setCodigo('61900');
$beneficiario->setNome('Minha Empresa LTDA');
$beneficiario->setCNPJ('52834351000100');

$cliente = new Cliente();
$cliente->setNome('Fulano da Silva');
$cliente->setCPF('48224257703');

$formato = new HTML();

$boleto = new Boleto();
$boleto->setBeneficiario($beneficiario);
$boleto->setCliente($cliente);
$boleto->setNumero('00111'); // Nosso número
$boleto->setDocumento('00111');
$boleto->setBanco($banco);
$boleto->setValor(11135.00);
$boleto->setDataVencimento(strtotime('+7 days'));
$boleto->setEspecieDocumento('A');
$boleto->setFormato($formato);

echo $boleto->gerar();
```

![Boleto Sicredi](/example/boleto_sicredi.png?raw=true "Exemplo de boleto gerado")

### Solução de problemas
O código foi implementado e testado com PHP 5.4, verifique sua versão do PHP em caso de falhas na execução

### Dependências
- PHP 5.3 ou superior
- Extenção GD2 para código de barras em PNG

### Limitações
- Geração para PDF e PNG estão pendentes
- Apenas para o banco Sicredi foi implementado a geração do boleto, mas ainda não foi testado
 
### Licença
Por favor veja o [arquivo de licença](/LICENSE.txt) para mais informações.
