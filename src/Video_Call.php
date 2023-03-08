<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;

class VideoCallRoom implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New client connected ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        switch ($data['type']) {
            case 'offer':
                $offer = $data['offer'];

                foreach ($this->clients as $client) {
                    if ($client !== $from) {
                        $client->send(json_encode([
                            'type' => 'offer',
                            'offer' => $offer
                        ]));
                    }
                }
                break;

            case 'answer':
                $answer = $data['answer'];

                foreach ($this->clients as $client) {
                    if ($client !== $from) {
                        $client->send(json_encode([
                            'type' => 'answer',
                            'answer' => $answer
                        ]));
                    }
                }
                break;

            case 'candidate':
                $candidate = $data['candidate'];

                foreach ($this->clients as $client) {
                    if ($client !== $from) {
                        $client->send(json_encode([
                            'type' => 'candidate',
                            'candidate' => $candidate
                        ]));
                    }
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Client {$conn->resourceId} disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new VideoCallRoom()
        )
    ),
    8080
);

$server->run();
?>