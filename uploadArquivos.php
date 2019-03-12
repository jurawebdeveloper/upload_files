<?php 
include "funcoes.php";
$nome = ($_POST['name']);
//print_r($nome); exit; 

$msg = false;

if( isset($_POST['enviou']) && $_POST['enviou'] == 1 ){
    
    // arquivo
	$arquivo = $_FILES['arquivo'];
 
    // Tamanho máximo do arquivo (em Bytes)
    $tamanhoPermitido = 1024 * 1024 * 2; // 2Mb
 
    //Define o diretorio para onde enviaremos o arquivo
    $diretorio = "uploads/";
 
    // verifica se arquivo foi enviado e sem erros
    if( $arquivo['error'] == UPLOAD_ERR_OK ){
 
        // pego a extensão do arquivo
        $extensao = extensao($arquivo['name']);
 
        // valida a extensão
        if( in_array( $extensao, array("pdf") ) ){
 
            // verifica tamanho do arquivo
            if ( $arquivo['size'] > $tamanhoPermitido ){
 
                $msg = "<strong>Aviso!</strong> O arquivo enviado é muito grande, envie arquivos de até ".$tamanhoPermitido/MB." MB.";
                $class = "alert-warning";
                print_r($tamanhoPermitido); exit;
 
            }else{
 
                // atribui novo nome ao arquivo
                //$novo_nome  = md5(time()).".".$extensao;
                $novo_nome  = $nome.".".$extensao;
 
                // faz o upload
                $enviou = move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome);
 
                if($enviou){
                    $msg = "<strong>Sucesso!</strong> Arquivo enviado corretamente.";
                    $class = "alert-success";
                }else{
                    $msg = "<strong>Erro!</strong> Falha ao enviar o arquivo.";
                    $class = "alert-danger";
                }
            }
 
        }else{
            $msg = "<strong>Erro!</strong> Somente arquivos PDF são permitidos.";
            $class = "alert-danger";
        }
 
    }else{
        $msg = "<strong>Atenção!</strong> Você deve enviar um arquivo.";
        $class = "alert-info";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
<?php if ($msg != false) echo "<div class=\"alert $class\" role=\"alert\">$msg</div>"; ?>
</body>
</html>