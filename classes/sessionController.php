<?php

// esta clase maneja de la misma manera las sessiones pero con la autenticacion de usuarios tambien
class SessionController extends Controller
{

    // creamos nuestros atributos
    private $userSession;
    private $userCorreo;
    private $userid;
    private $sitiosPredeterminados;

    private $session;
    private $sites;

    private $user;

    function __construct()
    {
        parent::__construct();

        // cuando se cree un nuevo objeto de sessionController va llamar a init
        $this->init();
    }
    // Esta funcion la vamos a implementar para leer el JSON y asi dar los permisos
    private function init()
    {
        //se crea nueva sesión
        $this->session = new Session();
        //se carga el archivo json con la configuración de acceso
        $json = $this->getConfiguracionJSON();
        // se asignan los sitios
        $this->sites = $json['sites'];
        // se asignan los sitios por default, los que cualquier rol tiene acceso
        $this->sitiosPredeterminados = $json['default-sites'];
        // inicia el flujo de validación para determinar
        // el tipo de rol y permismos
        $this->validarSession();
    }
    // esta funcion nos permite abrir el archivo y devolver la data decodificada
    private function getConfiguracionJSON()
    {
        // asignamos el contenido de access a string
        $string = file_get_contents("config/access.json");
        // decoficamos el JSON en un array de objetos
        $json = json_decode($string, true);

        return $json;
    }

    /**
     * Implementa el flujo de autorización
     * para entrar a las páginas
     */

    // funcion para implementar el flujo de autorizacion para entrar a las paginas
    public function validarSession()
    {
        error_log('SessionController::validarSession()');

        // Verificar si la solicitud es AJAX
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        // Si existe la sesión
        if ($this->existeSession()) {
            // Obtenemos el rol para los permisos, con todo el usuario.
            $role = $this->getDatosUsuarioSession()->getRol();

            error_log("sessionController::validarSession(): username:" . $this->user->getCorreo() . " - role: " . $this->user->getRol());

            if ($this->esSitioPublico()) {
                // Si la página es pública entonces que lo rediriga a la página principal de cada rol
                $this->rederigirSitioPorRol($role);
                error_log("SessionController::validarSession() => sitio público, redirige al main de cada rol");
            } else {
                // Validación de usuario para el login
                if ($this->estaAutorizado($role)) {
                    error_log("SessionController::validarSession() => autorizado, lo deja pasar");
                } else {
                    error_log("SessionController::validarSession() => no autorizado, redirige al main de cada rol");
                    $this->rederigirSitioPorRol($role);
                }
            }
        } else {
            // No existe ninguna sesión
            if ($this->esSitioPublico()) {
                error_log('SessionController::validarSession() public page');
            } else {
                if ($isAjax) {
                    // Si es una solicitud AJAX y no hay sesión, responde con un código de estado HTTP 401
                    http_response_code(401);
                    echo json_encode(['error' => 'Usuario no autenticado']);
                } else {
                    error_log('SessionController::validarSession() redirect al login');
                    header('location: ' . constant('URL') . 'login');
                }
            }
        }
    }
    /**
     * Valida si existe sesión, 
     * si es verdadero regresa el usuario actual
     */
    function existeSession()
    {   
        // validamos que exista una session abierta
        if (!$this->session->existe()) return false;
        // si tambien la data de la session del usuario esta vacia retornamos false
        if ($this->session->getUsuarioActual() == NULL) return false;

        // si no entra en los dos condicionales anteriores, eso significa que existe una session        
        $userid = $this->session->getUsuarioActual();


        // si existe retorna true
        if ($userid) return true;

        return false;
    }
    
    // esta funcion nos servira para crear un nuevo modelo del usuario dependiendo de los datos de la session
    function getDatosUsuarioSession()
    {
        $id = $this->session->getUsuarioActual();
        $this->user = new JoinUserRelationsModel();

        // obtenemos la data del usuario que tiene session en user apartir del id
        $this->user->consultar($id);
        error_log("sessionController::getDatosUsuarioSession(): " . $this->user->getNombres());
        // finalmente retornamos toda la data del usuario
        return $this->user;
    }

    
    // la funcion initialize nos va permitir llamar autorizarAcceso y establecer el
    public function inicializar($user)
    {
        // error_log("sessionController::initialize(): user: " . $user->getNombres());
        $this->session->setUsuarioActual($user->getCorreo());
        $this->autorizarAcceso($user->getRol());
    }
    
    // funcion para validar si una pagina es publica o no
    private function esSitioPublico()
    {
        $currentURL = $this->getPaginaActual();
        error_log("sessionController::esSitioPublico(): currentURL => " . $currentURL);
        // utilizamos una expresion regular para remplazar todos los caracteres que especificamos 
        // por un string vacio y va ser aplicado de currentURL
        $currentURL = preg_replace("/\?.*/", "", $currentURL); //omitir get info
        // utilizamos el for para recorrer el arreglo de objetos de sites y comparar si es publico o no

        for ($i = 0; $i < sizeof($this->sites); $i++) {
            if ($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['access'] === 'public') {
                return true;
            }
        }
        return false;
    }

    // utilizamos esta funcion para redirigir al usuario a su respectivo sitio por rol
    private function rederigirSitioPorRol($role)
    {
        $url = '';
        for ($i = 0; $i < sizeof($this->sites); $i++) {
            // Dependiendo del rol, lo redirigimos a una página u otra
            if ($this->sites[$i]['role'] == $role) {
                $url = $this->sites[$i]['site'];
                break;
            }
        }
        // Redirigimos finalmente con URL mapeada
        header('location: ' .constant('URL'). $url);
    }
    // esta funcion nos sirve para validar, si ese usuario esta autorizado para entrar y ver esa pagina
    private function estaAutorizado($role)
    {
        $currentURL = $this->getPaginaActual();
        $currentURL = preg_replace("/\?.*/", "", $currentURL); //omitir get info

        for ($i = 0; $i < sizeof($this->sites); $i++) {
            // aqui verificamos el rol y el sitio, entonces si, si tiene acceso retornamos true
            if ($currentURL == $this->sites[$i]['site'] && $this->sites[$i]['role'] == $role) {
                error_log("SessionController::estaAutorizado -> Role ".$role." is validate for this site ".$currentURL);
                return true;
            }
        }
        return false;
    }

    // esta funcion nos va permitir obtener la pagina actual
    private function getPaginaActual()
    {
        // obtenemos la url actual
        $actual_link = trim("$_SERVER[REQUEST_URI]");
        // separamos la url por diagonales, retornandonos un arreglo con los elementos de la URL
        $url = explode('/', $actual_link);
        error_log("sessionController::getPaginaActual(): actualLink =>" . $actual_link . ", url => " . $url[2]);
        // despues del http
        return $url[2];
    }

    // esta funcion nos permite redigir al usuario haci su sitio principal
    function autorizarAcceso($role)
    {
        error_log("sessionController::autorizarAcceso(): role: $role");
        switch ($role) {
            case 'Administrador':
                $this->redirect($this->sitiosPredeterminados['admin'], []);
                break;
            case 'Mesero':
                $this->redirect($this->sitiosPredeterminados['mesero'], []);
                break;
            case 'Cajero':
                $this->redirect($this->sitiosPredeterminados['cajero'], []);
                break;
            case 'Cheff':
                $this->redirect($this->sitiosPredeterminados['cheff'], []);
            default:
        }
    }


    // funcion para cerrar la session
    function cerrarSesion()
    {
        $this->session->cerrarSesion();
    }
}
