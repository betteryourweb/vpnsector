<?php

namespace Betteryourweb\Commands\Openvpn;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Betteryourweb\Openvpn\Status;

class GetStatsCommand extends Command{
	public function configure () {
		$this->setName('stats')
			->setDescription("Get OpenVPN Stats");
	}

	public function execute(InputInterface $input, OutputInterface $output){
		//Read Openvpn Stat File
		
		//Separate Openvpn File into section 
		
		//
		$status = new Status('/etc/openvpn/openvpn-status.log');
		echo $status->toJson();

	}
}