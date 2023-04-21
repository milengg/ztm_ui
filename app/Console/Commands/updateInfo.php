<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Changelog;
use Exception;

class UpdateInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:changelog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding details about updates on the system.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Changelog::truncate();
            $this->info('Зануляване на базата успешно!');
        } catch(Exception $e) {
            $this->error('Зануляване на базата неуспешно! - ' . $e);
        }
       
        $changelog_updates = [
            [
                'version' => '2.0.1',
                'type' => 'Добавен',
                'content' => 'Добавена виртуална клавиетура, добавена логика за пин код, добавена логика за параметри(CRUD)'
            ],
            [
                'version' => '2.0.2',
                'type' => 'Добавен',
                'content' => 'Добавени миграции за административна част на таблета, добавени контролери и логика за управление'
            ],
            [
                'version' => '2.0.3',
                'type' => 'Добавен',
                'content' => 'Добавена логика за ъпдейти, обновени екрани за сървър и клиент, добавена криптировка на комуникация'
            ],
            [
                'version' => '2.0.4',
                'type' => 'Добавен',
                'content' => 'Добавяне на бинарен файл за екзекуция режим на поддръжка'
            ],
            [
                'version' => '2.0.5',
                'type' => 'Добавен',
                'content' => 'Добавена поддръжка за текстове включващи цветовете: бяло, черно, червено и зелено'
            ],
        ];
        try {
            Changelog::insert($changelog_updates);
            $this->info('Данни за последни обновления бяха добавени успешно!');
        } catch(Exception $e)
        {
            $this->error('Данни за последни обновления бяха провалени - ' . $e);
        }
    }
}

