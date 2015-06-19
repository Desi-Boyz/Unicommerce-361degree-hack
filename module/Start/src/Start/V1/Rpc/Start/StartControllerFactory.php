<?php
namespace Start\V1\Rpc\Start;

class StartControllerFactory
{
    public function __invoke($controllers)
    {
        return new StartController();
    }
}
