
<?php
require 'vendor/autoload.php';
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $data) {
        $id = json_decode($data)->id;
        $token = json_decode($data)->token;
        $type = json_decode($data)->type;

        // $url = 'http://localhost/ttcms/api/'.$type.'/'.$id;
        $url = 'https://coral-app-oim7w.ondigitalocean.app/'.$type.'/'.$id;

        $headers = [
            'Content-Type: application/json',
            'Authorization: '.$token
        ];

        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0); 
        
        $response = curl_exec($ch);
        
        if(curl_errno($ch)) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            $data = json_decode($response, true);
            print_r($data);
        }
        
        curl_close($ch);


        foreach ($this->clients as $client) {
            $client->send($response);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();