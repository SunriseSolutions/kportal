<?php

namespace AppBundle\Command\BinhLe;

use AppBundle\Entity\BinhLe\ThieuNhi\ChristianName;
use AppBundle\Entity\BinhLe\ThieuNhi\ThanhVien;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Debug\Exception\ContextErrorException;

class ThieuNhiCommand extends ContainerAwareCommand {
	protected function configure() {
		$this
			// the name of the command (the part after "bin/console")
			->setName('app:binhle:thieunhi:migrate-christiannames')
			// the short description shown while running "php bin/console list"
			->setDescription('Migrate CNames')
			// the full command description shown when running the command with
			// the "--help" option
			->setHelp('This command allows you to migrate cnames of all Members...');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {
		// outputs multiple lines to the console (adding "\n" at the end of each line)
		$output->writeln([
			'Start migrating',
			'============',
			'',
		]);
		$manager      = $this->getContainer()->get('doctrine.orm.default_entity_manager');
		$cNameRepo    = $this->getContainer()->get('doctrine')->getRepository(ChristianName::class);
		$cacThanhVien = $this->getContainer()->get('doctrine')->getRepository(ThanhVien::class)->findBy([ 'tenThanh' => null ]);
		/** @var ThanhVien $tv */
		foreach($cacThanhVien as $tv) {
			if( ! empty($cname = $tv->getChristianname())) {
				$cname = mb_strtoupper(trim($cname));
				try {
//					$output->writeln($tv->getName());
					$enName = ThanhVien::$christianNames[ $cname ];
					if(empty($tenThanh = $cNameRepo->findBy([ 'code' => $enName ]))) {
						$tenThanh = new ChristianName();
						$tenThanh->getCacThanhVien()->add($tv);
						$tenThanh->setSex(ThanhVien::$christianNameSex[ $cname ]);
						$tenThanh->setTiengViet($cname);
						$tenThanh->setTiengAnh($enName);
						$tenThanh->setCode($enName);
						$manager->persist($tenThanh);
						$manager->flush();
					}
					$tv->setTenThanh($tenThanh);
					$manager->persist($tv);
				} catch(ContextErrorException $ex) {
					$output->writeln('ERROR ' . $ex->getTraceAsString());
					$output->writeln($tv->getChristianname());
					$output->writeln($tv->getName());
					$output->writeln($cname . ' - ' . $enName);
					
					$output->writeln(ThanhVien::$christianNames[ $cname ]);
//					var_dump(ThanhVien::$christianNameSex);
					die(- 1);
				}
			}
		}
		$output->writeln("Flushing");
		$manager->flush();
		$output->writeln("Successfully migrated all members with a Christian Name");
	}
}