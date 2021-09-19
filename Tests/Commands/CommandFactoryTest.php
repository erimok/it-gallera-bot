<?php

namespace Commands;

use App\API\Receiver;
use App\Commands\CommandFactory;
use App\Commands\CommandInterface;
use App\Commands\StartCommand;
use PHPUnit\Framework\TestCase;

final class CommandFactoryTest extends TestCase
{
    /**
     * @var CommandFactory
     */
    private $command_factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command_factory = new CommandFactory();

        $receiver = $this->getMockBuilder(Receiver::class)->getMock();

        $this->command_factory->setCommands([
            StartCommand::NAME => new StartCommand($receiver)
        ]);
    }

    public function testGetCommand()
    {
        // given
        $command_name = StartCommand::NAME;

        // when
        $command = $this->command_factory->getCommand($command_name);

        // then
        $this->assertInstanceOf(CommandInterface::class, $command);
        $this->assertEquals($command_name, $command::NAME);
    }

    public function testGetCommandWithWrongCommandName()
    {
        // given
        $command_name = 'test';

        // when
        $this->expectException(\Exception::class);
        $this->command_factory->getCommand($command_name);
    }
}
