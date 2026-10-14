<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Buku;
use App\Services\BukuCodeGenerator;

class ConvertBukuCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buku:convert-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert existing book codes to new format (ROM/001/Title)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting conversion of book codes...');

        $books = Buku::whereNotNull('genre')
            ->where('genre', '!=', '')
            ->get();

        if ($books->isEmpty()) {
            $this->warn('No books found with genre information.');
            return Command::SUCCESS;
        }

        $this->info("Found {$books->count()} books to convert.");
        
        $converted = 0;
        $skipped = 0;
        $errors = 0;

        $bar = $this->output->createProgressBar($books->count());
        $bar->start();

        foreach ($books as $book) {
            try {
                // Skip jika sudah format baru (contains /)
                if (strpos($book->kode_buku, '/') !== false) {
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                $newCode = BukuCodeGenerator::generate($book->genre, $book->judul);
                
                // Update kode buku
                $book->kode_buku = $newCode;
                $book->save();

                $converted++;
            } catch (\Exception $e) {
                $errors++;
                $this->newLine();
                $this->error("Error converting book ID {$book->id}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Conversion completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Converted', $converted],
                ['Skipped', $skipped],
                ['Errors', $errors],
                ['Total', $books->count()],
            ]
        );

        return Command::SUCCESS;
    }
}

