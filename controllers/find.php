<?
    function requestAnimeSources( $url, $isPost = false, $postfields = null ){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, $isPost);
        if(!empty($postfields)) curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $out = curl_exec($ch);
        curl_close($ch);
        return $out;
    }
    
    function pregAnchors( $regex, $out ){
        preg_match_all( $regex , $out, $matches);
        array_shift($matches);
        return $matches;
    }
    
    function arrayParse( $matches ){
        $array = array();
        foreach($matches[0] as $key => $value){
            preg_match("/[http|https]+:\/\/.*\..*?\//", $value, $domain);
            $array[$key] = array(
                "domain" => $domain[0],
                "href" => $value,
                "title" => $matches[1][$key],
                "date" => (int) filter_var($matches[2][$key], FILTER_SANITIZE_NUMBER_INT)
            );
        }
        return $array;
    }
    
    function findAnime( $array ){
        $out = requestAnimeSources( $array["url"], $array["isPost"], $array["postfields"] );
        $matches = pregAnchors( $array["regex"], $out );
        return arrayParse( $matches );
    }
    
    function substValues( $value, $page, $title){
        return strtr(
            $value,
            [
                '{$page}' => $page,
                '{$title}' => $title
            ]
        );
    }

    function getSources(){
        $json = file_get_contents( 'sources.json' );
        return json_decode( $json, true );
    }

    $title = $_GET["title"];
    $page = $_GET["page"] ?: 1;
    !empty($title) ?: header("Location: /");

    $sources = getSources();
    $titleForSearch = str_replace(" ", "+", $title);

    $results = array();
    foreach($sources as $key => &$value){
        $value["url"] = substValues( $value["url"], $page, $titleForSearch);
        $value["postfields"] = substValues( $value["postfields"], $page, $titleForSearch);
        $results = array_merge( $results, findAnime($value));
    }

    view("find", ["title" => $title, "results" => $results]);
?>