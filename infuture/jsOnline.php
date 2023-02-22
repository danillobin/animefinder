<?
    class jsOnline{

        private $curlHeaders = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36',
            'content-type: application/json'
        ];

        public function __construct() {

        }

        private function request( $url, $postfields ){
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_COOKIESESSION, true );
            curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . "/cookies.txt" );
            curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . "/cookies.txt" );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->curlHeaders);
            $out = curl_exec($ch);
            curl_close($ch);
            return $out;
        }

        private function edit_code($js){
            $js = str_replace("\\", "\\\\", $js);
            $js = str_replace('"', '\\"', $js);
            return str_replace("\n", "\\n", $js);
        }

        private function isUnAuth($data){
            return $data->stderr == "URLs found in the code! \nYou must login to run this program.";
        }

        private function get_postfields($js){
            return <<< EOT
            {"name":"JavaScript","title":"3yxsnw2wn","version":"ES6","mode":"javascript","description":null,"extension":"js","languageType":"programming","active":true,"properties":{"language":"javascript","docs":true,"tutorials":true,"cheatsheets":true,"filesEditable":true,"filesDeletable":true,"files":[{"name":"index.js","content":"$js"}],"newFileOptions":[{"helpText":"New JS file","name":"script\${i}.js","content":"/**\\n *  In main file\\n *  let script\${i} = require('./script\${i}');\\n *  console.log(script\${i}.sum(1, 2));\\n */\\n\\nfunction sum(a, b) {\\n    return a + b;\\n}\\n\\nmodule.exports = { sum };"},{"helpText":"Add Dependencies","name":"package.json","content":"{\\n  \\"name\\": \\"main_app\\",\\n  \\"version\\": \\"1.0.0\\",\\n  \\"description\\": \\"\\",\\n  \\"main\\": \\"HelloWorld.js\\",\\n  \\"dependencies\\": {\\n    \\"lodash\\": \\"^4.17.21\\"\\n  }\\n}"}],"result":{"success":false,"output":"index.js:1\\ntut text\\n    ^^^^\\n\\nSyntaxError: Unexpected identifier\\n    at Object.compileFunction (node:vm:352:18)\\n    at wrapSafe (node:internal/modules/cjs/loader:1032:15)\\n    at Module._compile (node:internal/modules/cjs/loader:1067:27)\\n    at Object.Module._extensions..js (node:internal/modules/cjs/loader:1157:10)\\n    at Module.load (node:internal/modules/cjs/loader:981:32)\\n    at Function.Module._load (node:internal/modules/cjs/loader:822:12)\\n    at Function.executeUserEntryPoint [as runMain] (node:internal/modules/run_main:77:12)\\n    at node:internal/main/run_main_module:17:47"}},"visibility":"public","_id":"3yxsnw2wn","user":null,"idToken":"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjN5eHNudzJ3biIsImlhdCI6MTY3NjI4Mzc3Mn0.mu63aSdWSX25pjQeO3XMlqZeJaqGwxIjvK14E0OXffY"}
            EOT;
        }

        private function auth(){
            $url = "https://onecompiler.com/api/users";
            $postfields = '{"provider":"onecompiler","data":{"email":"czacind@bk.ru","password":"randompassworddaniel"}}';
            print_r($this->request( $url, $postfields));
        }
        
        private function sendJS($js, $need_edit = 0){
            if($need_edit) $js = $this->edit_code($js);
            $url = "https://onecompiler.com/api/code/exec";
            $postfields = $this->get_postfields($js);
            $out = $this->request( $url, $postfields);
            return json_decode($out);
        }

        public function exec($js, $need_edit = 0){
                $data = $this->sendJS( $js, $need_edit );
                if($this->isUnAuth($data)) {
                    $this->auth();
                    //$data = $this->sendJS( $js, $need_edit );
                    // if($this->isUnAuth($data)){
                    //     header('HTTP/1.0 403 Forbidden');
                    //     echo 'An unexpected error has occurred. Please try again later!';
                    //     unset($data);
                    // }
                }
                //return $data;
        }
    }

?>