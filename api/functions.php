<?
function getComponent( $name, $__args = array() ){
    extract($__args);
    require("components/$name.php");
}

function view( $name, $__args = array() ){
    extract($__args);
    require("views/$name.php");
}

function routing(){
    print_r($_SERVER['REDIRECT_URL']);
    switch ($_SERVER['REDIRECT_URL']) {
        case '':
        case '/':
        case '/index':
            include_once 'controllers/home.php';
            break;
        case '/find':
            include_once 'controllers/find.php';
            break;
        default:
            header("Location: /");
            break;
    }
}

function _remove_empty_internal($value) {
    return !empty($value) || $value === "0" || $value === 0;
}

function killWhitespace($var){
    $var = str_replace(chr(194), "", $var);
    return str_replace(chr(160), " ", $var);
}

?>