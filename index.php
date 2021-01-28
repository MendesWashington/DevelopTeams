<br> <br>
<?php

	//Lib loader
	require_once 'Lib/Livro/Core/ClassLoader.php';
	$al = new Livro\Core\ClassLoader;
	$al->addNamespace('Livro', 'Lib/Livro');
	$al->register();
	

	//App loader
	require_once 'Lib/Livro/Core/AppLoader.php';
	$al = new Livro\Core\AppLoader;
	$al->addDirectory('App/Control');
	$al->addDirectory('App/Model');
	$al->register();

	use Livro\Control\Page;
	use Livro\Session\Session;
	use Livro\Widgets\Dialog\Message;

	$content = '';

	new Session;

	if(Session::getValue('logged')){
		$template = file_get_contents('App/Templates/adm.html');
		$class = '';
	}else{
		$template = file_get_contents('App/Templates/index.html');
		$class = 'LoginForm';
	}
	
	if(isset($_GET['class']) AND Session::getValue('logged')){
		$class = $_GET['class'];
	}

	
	if(class_exists($class)){
		try {
			$pagina = new $class;
			ob_start();
			$pagina->show();
			$content = ob_get_contents();
			ob_end_clean();
		} catch (Exception $e) {
			new Message('danger' , 'Há pagina solicitada não pode ser encontrada tente novamente! <br>'.$e->getTraceAsString());
		}
	}
	$output = str_replace('{content}', $content, $template);
	$output = str_replace('{class}', $class, $output);
	echo $output;


	/*if($_GET){
		$class = $_GET['class'];
		if(class_exists($class)){
			$pagina = new $class;
			$pagina->show();
		}else{
			new Message('danger' , 'Há pagina solicitada não pode ser encontrada tente novamente!');
		}
	}*/
?>
