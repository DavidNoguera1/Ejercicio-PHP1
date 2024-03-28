<?php

class Noticia
{
    //Declaracion  de las variables que se utilizaran en la cl
    private $id;
    private $titulo;
    private $fecha;
    private $autor;
    private $noticia;

    // constructor de la clase
    public function __construct($id, $titulo, $fecha, $autor, $noticia)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->fecha = $fecha;
        $this->autor = $autor;
        $this->noticia = $noticia;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getAutor()
    {
        return $this->autor;
    }

    public function getNoticia()
    {
        return $this->noticia;
    }
}

class gestorNoticia
{
    private $noticias = [];

    public function __construct()
    {
        $this->cargarNoticias();
    }

    public function getNoticias()
    {
        return $this->noticias;
    }

    //Metodos

    private function cargarNoticias()
    {
        $archivo = "data.txt";
        if (file_exists($archivo)) {
            $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
            foreach ($lineas as $linea) {
                $datos = explode("|", $linea);
                $id = $datos[0];
                $titulo = $datos[1];
                $fecha = $datos[2];
                $autor = $datos[3];
                $noticia = $datos[4];

                // Verificar si la noticia ya existe antes de agregarla
                $noticiaExistente = false;
                foreach ($this->noticias as $not) {
                    if ($not->getId() == $id) {
                        $noticiaExistente = true;
                        break;
                    }
                }

                if (!$noticiaExistente) {
                    $this->noticias[] = new Noticia($id, $titulo, $fecha, $autor, $noticia);
                }
            }
        }
    }

    public function agregarNoticia($id, $titulo, $fecha, $autor, $noticia)
    {
        // Verificar si la noticia ya existe antes de agregarla
        $noticiaExistente = false;
        if (file_exists("data.txt")) {
            $lineas = file("data.txt", FILE_IGNORE_NEW_LINES);
            foreach ($lineas as $linea) {
                $datos = explode("|", $linea);
                if ($datos[0] == $id) {
                    $noticiaExistente = true;
                    break;
                }
            }
        }

        if (!$noticiaExistente) {
            // Create a new string with the noticia data
            $str = $id . "|" . $titulo . "|" . $fecha . "|" . $autor . "|" . $noticia . "\n";

            // Write the new noticia string to the file
            file_put_contents("data.txt", $str, FILE_APPEND);

            // Add the new noticia to the $this->noticias array
            $this->noticias[] = new Noticia($id, $titulo, $fecha, $autor, $noticia);
        }
    }

    public function eliminarNoticia($id)
    {
        // Buscar la noticia con el ID proporcionado en el array de noticias
        foreach ($this->noticias as $indice => $noticia) {
            if ($noticia->getId() == $id) {
                // Eliminar la noticia del array
                unset($this->noticias[$indice]);
                // Reindexar el array después de eliminar la noticia
                $this->noticias = array_values($this->noticias);
                // Sobrescribir el archivo con las noticias restantes
                $archivo = "data.txt";
                file_put_contents($archivo, '');

                // Escribir las noticias restantes en el archivo usando la función agregarNoticia()
                foreach ($this->noticias as $noticia) {
                    $this->agregarNoticia($noticia->getId(), $noticia->getTitulo(), $noticia->getFecha(), $noticia->getAutor(), $noticia->getNoticia());
                }

                // Redireccionar a recibe.php
                header("Location: recibe.php");
                exit(); // Asegurar que el script se detenga después de redireccionar
            }
        }
    }

    public function editarNoticia($id, $nuevoTitulo, $nuevaFecha, $nuevoAutor, $nuevaNoticia)
    {
        foreach ($this->noticias as $noticia) {
            if ($noticia->getId() == $id) {
                // Actualizar los datos de la noticia
                $noticia->titulo = $nuevoTitulo;
                $noticia->fecha = $nuevaFecha;
                $noticia->autor = $nuevoAutor;
                $noticia->noticia = $nuevaNoticia;

                // Sobrescribir el archivo con las noticias actualizadas
                $archivo = "data.txt";
                $contenido = "";
                foreach ($this->noticias as $not) {
                    $str = $not->getId() . "|" . $not->getTitulo() . "|" . $not->getFecha() . "|" . $not->getAutor() . "|" . $not->getNoticia() . "\n";
                    $contenido .= $str;
                }
                file_put_contents($archivo, $contenido);

                // Redireccionar a recibe.php
                header("Location: recibe.php");
                exit(); // Asegurar que el script se detenga después de redireccionar
            }
        }
    }
}
?>