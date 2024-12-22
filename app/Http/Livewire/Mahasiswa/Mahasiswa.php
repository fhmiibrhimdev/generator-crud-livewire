<?php

namespace App\Http\Livewire\Mahasiswa;

use App\Models\Mahasiswa as ModelsMahasiswa;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Mahasiswa extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete'
    ];

    protected $rules = [
        'nama_lengkap'        => 'required',
        'nim'                 => 'required',
        'deskripsi'           => 'required',
    ];

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $lengthData  = 10;
    public $updateMode  = false;
    public $idRemoved   = NULL;
    public $dataId      = NULL;

    public $nama_lengkap;
    public $nim;
    public $deskripsi;

    public function render()
    {
        $search     = '%'.$this->search.'%';
        $lengthData = $this->lengthData;

        $data = ModelsMahasiswa::where(function ($query) use ($search) {
                    $query->where('nama_lengkap', 'LIKE', $search);
                    $query->orWhere('nim', 'LIKE', $search);
                    $query->orWhere('deskripsi', 'LIKE', $search);
                })
                ->orderBy('id', 'ASC')
                ->paginate($lengthData);

        return view('livewire.mahasiswa.mahasiswa', compact('data'))
        ->extends('layouts.apps', ['title' => 'Mahasiswa']);
    }

    public function mount()
    {
        $this->nama_lengkap        = '';
        $this->nim                 = '';
        $this->deskripsi           = '';
     }
    
    private function resetInputFields()
    {
        $this->nama_lengkap        = '';
        $this->nim                 = '';
        $this->deskripsi           = '';
     }

    public function cancel()
    {
        $this->updateMode       = false;
        $this->resetInputFields();
    }

    private function alertShow($type, $title, $text, $onConfirmed, $showCancelButton)
    {
        $this->alert($type, $title, [
            'position'          => 'center',
            'timer'             => '3000',
            'toast'             => false,
            'text'              => $text,
            'showConfirmButton' => true,
            'onConfirmed'       => $onConfirmed,
            'showCancelButton'  => $showCancelButton,
            'onDismissed'       => '',
        ]);
        $this->resetInputFields();
        $this->emit('dataStore');
    }

    public function store()
    {
        $this->validate();

        ModelsMahasiswa::create([
            'nama_lengkap'        => $this->nama_lengkap,
            'nim'                 => $this->nim,
            'deskripsi'           => $this->deskripsi,
        ]);

        $this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil ditambahkan', 
            '', 
            false
        );
    }

    public function edit($id)
    {
        $this->updateMode       = true;
        $data = ModelsMahasiswa::where('id', $id)->first();
        $this->dataId           = $id;
        $this->nama_lengkap     = $data->nama_lengkap;
        $this->nim              = $data->nim;
        $this->deskripsi        = $data->deskripsi;
    }

    public function update()
    {
        $this->validate();

        if( $this->dataId )
        {
            ModelsMahasiswa::findOrFail($this->dataId)->update([
                'nama_lengkap'        => $this->nama_lengkap,
                'nim'                 => $this->nim,
                'deskripsi'           => $this->deskripsi,
            ]);
            $this->alertShow(
                'success', 
                'Berhasil', 
                'Data berhasil diubah', 
                '', 
                false
            );
        }
    }

    public function deleteConfirm($id)
    {
        $this->idRemoved = $id;
        $this->alertShow(
            'warning', 
            'Apa anda yakin?', 
            'Jika anda menghapus data tersebut, data tidak bisa dikembalikan!', 
            'delete', 
            true
        );
    }

    public function delete()
    {
        ModelsMahasiswa::findOrFail($this->idRemoved)->delete();
        $this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil dihapus', 
            '', 
            false
        );
    }
}