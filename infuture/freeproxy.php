<?
require("test.php");
require("jsOnline.php");

class spysone{

    private $selector = '//tr[@class="spy1x"]|//tr[@class="spy1xx"]';

    private function pregMatchxx0($data){
        preg_match("/<input type='hidden' name='xx0' value='(.*?)'>/", $data ,$xx0);
        return $xx0[1];
    }

    private function sendRequest( $xx0 = 0 ){
        $ch = curl_init("https://spys.one/proxies/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "xx0=$xx0&xpp=5&tldc=0&xf1=1&xf2=0&xf4=0&xf5=1");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
        ]);
        $out = curl_exec($ch);
        curl_close($ch);
        return [$this->pregMatchxx0($out), $out];
    }

    private function getxx0(){
        return $this->sendRequest()[0];
    }

    private function getProxyHTML(){
        $xx0 = $this->getxx0();
        return $this->sendRequest($xx0)[1];
    }

    private function parseHTML($HTML){
        $dom = new DomDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($HTML);
        libxml_clear_errors();
        $xpath = new DOMXpath($dom);
        $elements = NODEToArray( $xpath, $this->selector );
        $elements = array_map('trim', $elements);
        return array_filter($elements, "_remove_empty_internal");
    }

    private function getEval($HTML){
        preg_match("/(eval[.*\s\S]*?)<\/script/", $HTML, $eval);
        return $eval[1];
    }

    private function clearGuard( $action, $value ){
        $ch = curl_init("https://spys.one/$action");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "md=$value");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
        ]);
        $out = curl_exec($ch);
        curl_close($ch);
        print_r($out);
    }

    private function hasGuard($HTML){
        preg_match('/<form id="challenge-form" action="(.*?)"/', $HTML, $action);
        preg_match('/<input type="hidden" name="md" value="(.*?)"/', $HTML, $value);
        if($action[0] && $value[0]){
            $data = $this->clearGuard( $action[0], $value[0]);
        }
    }

    function getProxy(){
        $HTML = $this->getProxyHTML();
        $HTML = str_replace( "\/proxies", "https://spys.one/\/proxies", $HTML);
        //$HTML = str_replace( "/cdn-cgi", "https://spys.one/proxies/cdn-cgi", $HTML);
        //$this->hasGuard($HTML);
        print_r($HTML);

        // $elements = $this->parseHTML( $HTML );
        // $elements = array_slice($elements, 11);
        // $eval = $this->getEval($HTML);

        // $arr = array();
        // foreach($elements as $key => $value){
        //     if($key % 8 === 0) array_push($arr, $value);
        // }
        // $arr = implode( ';console.log("', $arr);
        // $arr = 'console.log("'.str_replace( 'document.write("', '', $arr);

        // //$to_print = explode("document.write", $elements[11]);
        // $js = new jsOnline();
        // $to_exec = $eval.$arr;
        // $out = $js->exec($to_exec, 1);

        // print_r($HTML);
        
    }
}

$proxyparser = new spysone();
$proxy = $proxyparser->getProxy();





// $dom = new DomDocument();
// $dom->loadHTML($out);
// $xpath = new DOMXpath($dom);
// $elements = NODEToArray( $xpath, $selector );
// $elements = array_map('trim', $elements);
// $elements = array_filter($elements, "_remove_empty_internal");


?>