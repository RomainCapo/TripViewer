<?php

/**
 *
 */
class Helper
{
    public static function display($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    // dd = display & die
	public static function dd($data)
    {
		echo '<pre>';
		var_dump($data);
		echo '</pre>';

		die();
	}

    public static function view($name, $data = [])
    {
        extract($data); // Importe les variables dans la table des symboles
                        // voir: http://php.net/manual/fr/function.extract.
                        // voir aussi la méthode compact()
        return require "app/views/{$name}.view.php";
    }


    public static function redirect($path)
    {
        header("Location: /{$path}");
        exit();
    }

    public static function mb_ucfirst($string, $encoding)
    {
      $strlen = mb_strlen($string, $encoding);
      $firstChar = mb_substr($string, 0, 1, $encoding);
      $then = mb_substr($string, 1, $strlen - 1, $encoding);
      return mb_strtoupper($firstChar, $encoding) . $then;
    }
}
