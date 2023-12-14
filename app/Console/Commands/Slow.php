<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class Slow extends Command
{
    protected $signature = 'app:slow';

    public function handle()
    {
        $start = microtime(true);

        $data = $this->data();

        dump('Read Data: '.sprintf('%.4f', microtime(true) - $start));

        dump('Items: '.count($data['items']));

        $start = microtime(true);

        Validator::make($data, [
            'items' => ['array'],
            'items.*.id' => ['required', 'numeric'],
            'items.*.type' => ['required', 'string'],
            'items.*.public' => ['required', 'boolean'],
            'items.*.created_at' => ['required'],
        ]);

        dump('Validator Time: '.sprintf('%.4f', microtime(true) - $start));
    }

    protected function data(): array
    {
        return ['items' => json_decode(file_get_contents(base_path('large-file.json')), true)];
    }
}
