<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Encryption\Encrypter;

class NewClient extends Command{

    protected $signature = 'encoderspy:newclient {client : Nombre del Cliente}';
	protected $description = 'Instalar Cliente';

	private $files;

    public function __construct(FileSystem $files){
		parent::__construct();
		$this->files = $files;
	}


	public function handle(){

		$this->client = strtolower($this->argument('client'));

		if($this->checkUser())
			$this->create();

    }

	private function checkUser(){

		if (!file_exists(base_path("client/$this->client"))) {
			$this->info("{$this->client} está siendo instalado");
			return true;
		} else {
			$this->error("Cliente '{$this->client}' ya existe");
			return false;
		}

    }

    private function create(){

		$client = $this->client;

		$this->info('Creando Directorios');
		$this->clientDirectory($client);

		$this->info('Creando Directorios en el Storage');
		// Storage Framework Directory
		$frame = storage_path('framework');

		// Framwork Cache, Session, View Directory
		$this->files->makeDirectory("$frame/cache/$client");
		$this->files->makeDirectory("$frame/sessions/$client");
		$this->files->makeDirectory("$frame/views/$client");

		// Set .env Values
		$this->setEnvValues($client);
    }

    private function setEnvValues($client){
		$this->info('Generate APP_KEY APP_ENV');
		$key ='base64:'.base64_encode(Encrypter::generateKey(config('app.cipher')));

		$path = base_path("client/$client/.env");

        // SET APP_KEY
		file_put_contents($path, preg_replace(
			"/^APP_KEY/m",
			'APP_KEY='.$key,
			file_get_contents($path)
        ));

        // SET APP_ENV
		file_put_contents($path, preg_replace(
			"/^APP_ENV=/m",
			'APP_ENV=production',
			file_get_contents($path)
		));

	}

    private function clientDirectory($client){

		$new = base_path("client/$client");
		$base = base_path("client/base");

		// Copy
		$this->files->copyDirectory($base, $new);

	}
}
