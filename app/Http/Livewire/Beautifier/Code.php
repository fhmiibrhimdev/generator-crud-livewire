<?php

namespace App\Http\Livewire\Beautifier;

use Livewire\Component;

class Code extends Component
{
    public $codeInput;
    public $codeOutput;

    public function beautify()
    {
        $this->codeOutput = $this->beautifyCode($this->codeInput);
    }

    private function beautifyCode($code)
    {
        $lines = explode("\n", $code);
        $maxLengths = [];

        foreach ($lines as $line) {
            // Pencarian menggunakan preg_match untuk mendeteksi '=>' atau '=' dengan kata di kedua sisi
            if (preg_match('/\s*(=>|=)\s*/', $line, $matches)) {
                // Jika ditemukan, ambil bagian sebelum dan sesudah '=>' atau '='
                $parts = explode($matches[1], $line, 2);
                $maxLengths[] = strlen(trim($parts[0]));
            }
        }

        $maxLength = !empty($maxLengths) ? max($maxLengths) : 0;

        $beautifiedLines = [];
        foreach ($lines as $line) {
            if (preg_match('/\s*(=>|=)\s*/', $line, $matches)) {
                // Jika ditemukan, ambil bagian sebelum dan sesudah '=>' atau '='
                $parts = explode($matches[1], $line, 2);
                $beautifiedLines[] = str_pad(trim($parts[0]), $maxLength) . ' ' . $matches[1] . ' ' . trim($parts[1]);
            } else {
                // Jika tidak ada '=>' atau '=', tambahkan baris asli
                $beautifiedLines[] = $line;
            }
        }

        $this->dispatchBrowserEvent('highlight-code');

        return implode("\n", $beautifiedLines);
    }


    public function render()
    {
        return view('livewire.beautifier.code')->extends('layouts.apps', ['title' => 'Beautifier Code']);
    }
}
