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
            [
                'version' => '2.0.6',
                'type' => 'Добавен',
                'content' => 'Добавени групи, масови операции по групи, версии по групи.'
            ],
            [
                'version' => '2.0.7',
                'type' => 'Добавен',
                'content' => 'Възможност за автоматично добавяне на таблети от сървър.'
            ],
            [
                'version' => '2.0.8',
                'type' => 'Добавен',
                'content' => 'Добавяне на логика блокер за ъпдейт процедури, блокер за процедури в изпълнение.'
            ],
            [
                'version' => '2.0.9',
                'type' => 'Добавен',
                'content' => 'Добавяне на фиксове за дарк тема.'
            ],
            [
                'version' => '2.1.0',
                'type' => 'Добавен',
                'content' => 'Тестов бранч.'
            ],
            [
                'version' => '2.1.1',
                'type' => 'Добавен',
                'content' => 'Групи редактиране, специални знаци в секция редактиране.'
            ],
            [
                'version' => '2.1.2',
                'type' => 'Добавен',
                'content' => 'Добавена парола за отключване и менажиране, разделение междо админ и потребител.'
            ],
            [
                'version' => '2.1.3',
                'type' => 'Добавен',
                'content' => 'Добавени икони за времето и логика в базата данни.'
            ],
            [
                'version' => '2.1.4',
                'type' => 'Добавен',
                'content' => 'Обновяване регистри. Добавяне нови регистри за щори от 1 од 4 зони.'
            ],
            [
                'version' => '2.1.5',
                'type' => 'Добавен',
                'content' => 'Добавяне полета за тампери и техните статуси.'
            ],
            [
                'version' => '2.1.6',
                'type' => 'Добавен',
                'content' => 'Добавен нов end-point /sync сменена логика на заявките.'
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

