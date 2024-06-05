
    <?php 
        // Vamos a crear una clase app(router), que nos permitira modificar la forma en la que hacemos solicitudes en nuestra aplicacion para routear las solicitudes a sus repectivos controladores

        require_once('controllers/errores.php');
        class App { 


            function __construct() { 
                // validamos que exista una url
                $url = isset($_GET['url']) ? $_GET['url'] : null;

                // tenemos que dividir nuestra url por slashes para ir analizando como descomponer la URL
                //con rtrim borramos cualquier diagonal que se encuentre al final de la URL'
                $url = rtrim($url, '/'); 
                
                //explode nos ayuda a separ la url en un elemento de un arreglo por cada slash / que encuentre 
                // ->http://localhost/fast/user/updatePhoto -> [localhost, fast, user, updatePhoto];
                $url = explode('/', $url); 


                // Si no existe ningun controlador en la url, entonces tiene que redirigirlo al login
                if(empty($url[0])) {
                    // usamos la nomenclatura class+metodo+mensaje para especificar el error
                    error_log('APP::construct->No hay controlador especificado');
                    // creamos una variable para cargar el controlador por default
                    $archivoController = 'controllers/landing.php';
                    // llamamos el controlador
                    require_once($archivoController);
                    // creamos una instancia del controlador
                    $controller = new Landing();
                    // renderizamos la vista o la mostramos
                    $controller->render();
                    // salimos de la funcion
                    return;
                }

                // Si trae controlador especificado -> url[0] -> nombre del controlador
                $archivoController = 'controllers/'. $url[0]. '.php';
                
                // validamos si existe el archivo
                if(file_exists($archivoController)) {
                    // llamamos el controlador
                    require_once($archivoController);

                    // creamos una nueva instancia de este objeto
                    $controller = new $url[0];
                    // cargamos su modelo que se llama igual que el controlador
                    $controller->loadModel($url[0]);


                    // tenemos que validar si hay un metodo para cargar, si no lo hay, cargamos un metodo por defecto

                    if(isset($url[1])) { 
                        // si existe el metodo, tenemos que validar que este dentro del controlador osea dentro de la clase

                        if(method_exists($controller, $url[1])) { 
                            // ahora debemos validar si existen parametros en la url, ademas que debemos injectarlos en nuestra funcion
                            if(isset($url[2])) { 
                                // ahora recuperamos el numero de los parametros
                                $nparam = count($url) - 2;
                                // esta variable va tener todos los parametros en forma de arreglo
                                $params = [];

                                // porcada parametro lo vamos agregar al arreglo
                                for($i = 0; $i < $nparam; $i++) { 
                                    // Lo agregamos
                                    // + 2 porque no contamos el controlador y tampoco el metodo
                                    array_push($params, $url[$i +2]);
                                }

                                // le pasamos al controlador los parametros atravez de el arreglo params
                                $controller->{$url[1]}();
                            }else { 
                                // llamamos el metodo tal cual sin incluir esos parametros, ya que no existen.
                                // llamamos el metodo de forma dinamica...
                                $controller->{$url[1]}();
                            }
                        }else { 
                            // no existe el metodo dentro del controlador(clase)
                            // si no existe el metodo del controlador lo va enviar a una pagina 404
                            $controller = new Errores(); 
                        }
                    }else { 
                        // no existe metodo a cargar, cargamos el metodo por default
                        // entonces todos los controladores van a tener el metodo render(), el cual va servir para cargar la pagina principal de cada controlador
                        $controller->render();
                    }
                }else { 
                    // No existe el archivo, entonces ejecuta el error
                    // Lo enviamos a una pagina 404 ya que no existe ese archivo tampoco.
                    $controller = new Errores();
                    $controller->render();


                }

            }
        }
    ?>