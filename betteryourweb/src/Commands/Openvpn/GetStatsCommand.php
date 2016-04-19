<?php

namespace Betteryourweb\Commands\Openvpn;

use Betteryourweb\Commands\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Betteryourweb\Openvpn\Status;
use Symfony\Component\Console\Helper\Table;

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
		// print_r($status->stats['clients']);
		// $this->database->query(
  //           'insert into tasks(description) values(:description)',
  //           compact('description')
  //       );
		$clientTable = new Table($output);

        $clientTable->setHeaders($status->stats['clients']['header'])
              ->setRows($status->stats['clients']['clients'])
              ->render();
		$routingTable = new Table($output);

        $routingTable->setHeaders($status->stats['routes']['header'])
              ->setRows($status->stats['routes']['routes'])
              ->render();
	}
}