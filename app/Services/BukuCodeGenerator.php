<?php

namespace App\Services;

use App\Models\Buku;

class BukuCodeGenerator
{
    /**
     * Generate kode buku otomatis berdasarkan genre dan judul
     */
    public static function generate(string $genre, string $judul): string
    {
        $genreConfig = config('genres.codes')[$genre] ?? null;
        
        if (!$genreConfig) {
            throw new \Exception("Genre '{$genre}' tidak ditemukan dalam konfigurasi");
        }

        $code = $genreConfig['code'];
        $start = $genreConfig['start'];
        $end = $genreConfig['end'];

        // Cari nomor terakhir yang digunakan dalam rentang genre ini
        $lastNumber = self::getLastUsedNumber($code, $start, $end);
        
        // Generate nomor berikutnya
        $nextNumber = self::getNextNumber($lastNumber, $start, $end);

        // Format: ROM/001/Romeo dan Juliet
        return sprintf('%s/%03d/%s', $code, $nextNumber, $judul);
    }

    /**
     * Cari nomor terakhir yang digunakan untuk genre tertentu
     */
    private static function getLastUsedNumber(string $code, int $start, int $end): ?int
    {
        // Cari semua buku dengan prefix code ini
        $pattern = $code . '/%';
        
        $lastBook = Buku::where('kode_buku', 'LIKE', $pattern)
            ->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode_buku, '/', 2), '/', -1) AS UNSIGNED) DESC")
            ->first();

        if (!$lastBook) {
            return null;
        }

        // Extract nomor dari format ROM/001/Title atau ROM/001A/Title
        preg_match('/^[A-Z]+\/(\d+)[A-Z]?\//', $lastBook->kode_buku, $matches);
        
        if (isset($matches[1])) {
            return (int) $matches[1];
        }

        return null;
    }

    /**
     * Generate nomor berikutnya, handle collision dengan suffix A, B, C
     */
    private static function getNextNumber(?int $lastNumber, int $start, int $end): int
    {
        if ($lastNumber === null) {
            return $start;
        }

        $nextNumber = $lastNumber + 1;

        // Jika masih dalam rentang, return nomor biasa
        if ($nextNumber <= $end) {
            return $nextNumber;
        }

        // Jika sudah penuh (exceed range), mulai dari awal dengan suffix A
        // ponytail: collision handling A-Z suffix untuk 150+ buku per genre, implement saat ada genre >150 buku
        return $start;
    }
}
