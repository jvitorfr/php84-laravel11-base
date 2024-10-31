<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCacheAndReload extends Command
{
    protected $signature = 'cache:clear-and-reload';
    protected $description = 'Limpa caches e reinicia o worker da queue.';
    
    public function handle()
    {
        $this->info('Limpando cache de configuração...');
        $this->call('config:cache');
        
        $this->info('Limpando cache de rota...');
        $this->call('route:cache');
        
        $this->info('Limpando cache de visualizações...');
        $this->call('view:clear');
        
        $this->info('Limpando cache da aplicação...');
        $this->call('cache:clear');
        
        $this->info('Atualizando autoload do Composer...');
        shell_exec('composer dump-autoload');
        $this->info('Operações concluídas com sucesso!');
    }
}
