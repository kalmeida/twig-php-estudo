<?php
require_once 'vendor/autoload.php';

    /**
     * Aqui definimos o diretório de nossos aquivos de template
     */
    $loader = new Twig_Loader_Filesystem('src/view/templates');
    $twig = new Twig_Environment($loader);

    /**
     * Aqui será criando um simples filtro para formatar o telefone. A critério de teste,
     * estou reutilizando uma funcão criada pelo Luy disponível no http://ninguemfez.blogspot.com.br
     * http://ninguemfez.blogspot.com.br/2014/05/php-mascara-php-mask.html
     *
     * @param val será o value sem formatação
     * @param mask será a máscara aplicada. Em nosso caso '(##) ####-#####''
     */
    $phoneFilter = new Twig_SimpleFilter('maskPhone', function($val, $mask){
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++){
            if($mask[$i] == '#'){
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }else{
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    });

    /**
     * Com o filtro criando. Adicionamos ao Twig
     */
    $twig->addFilter($phoneFilter);

    /**
     * Caso queira, você pode alterar as tags do Twig
     * por exemplo, para abrir e fechar um bloco por default é {% %}, aqui alteramos a tag_block para apenas { }
     * Você pode alterar também a tag de variáveis seguindo o exemplo abaixo e acrescentando
     * a array de 'tag_variable' => array('', '')
     */
    $lexer = new Twig_Lexer($twig, array(
        'tag_block'   => array('{', '}')
    ));
    $twig->setLexer( $lexer );

    //Vamos definir algumas váriaveis nesta parte

    //Seu nome
    $name = "Cássio Almeida";

    //sua lista de contatos
    $contacts = array(
            array('name' => "Julio", 'phone' => '11988888889'),
            array('name' => "Fernanda", 'phone' => '1289999992'),
            array('name' => "Maria", 'phone' => '1123456710'),
            array('name' => "Julio", 'phone' => '2132343456'),
            array('name' => "Fernanda", 'phone' => '1188888888'),
            array('name' => "Maria", 'phone' => '11988288888')
    );

    /**
     * Agora vamos renderizar o template criado
     * O primeiro parâmetro passado é o teamplate criado e o segundo será uma array com as variáveis a serem preenchidas.
     * Em seu template deverá conter as variáveis 'name' e 'contacts'
     */
    $template = $twig->render('home.twig', array(
        'name' => $name,
        'contacts' => $contacts
    ));

    //Imprimimos o template já renderizado
    echo $template;
?>
