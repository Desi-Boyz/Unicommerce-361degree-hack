<?php
namespace Play\V1\Rpc\Play;

class PlayControllerFactory
{
    public function __invoke($controllers)
    {
        return new PlayController();
    }
}
