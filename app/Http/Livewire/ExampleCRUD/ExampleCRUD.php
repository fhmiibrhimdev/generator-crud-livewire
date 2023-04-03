<?php

namespace App\Http\Livewire\Blog;

use App\Models\Kategori as ModelsKategori;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Kategori extends Component
{
    use LivewireAlert;
    use WithPagination;


    protected $listeners = [
        'delete'
    ];
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'nama_kategori'     => 'required',
    ];

    public $search;
    public $lengthData  = 10;
    public $updateMode  = false;
    public $idRemoved   = NULL;
    public $dataId      = NULL;
    public $nama_kategori;

    public function render()
    {
        $search     = '%'.$this->search.'%';
        $lengthData = $this->lengthData;

        $data = ModelsKategori::where('nama_kategori', 'LIKE', $search)
                    ->orderBy('id', 'ASC')
                    ->paginate($lengthData);

        return view('livewire.blog.kategori', compact('data'))
        ->extends('layouts.apps', ['title' => 'Kategori']);
    }

    public function mount()
    {
        $this->nama_kategori    = '';
    }
    
    private function resetInputFields()
    {
        $this->nama_kategori    = '';
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

        ModelsKategori::create([
            'nama_kategori'     => $this->nama_kategori,
        ]);

        $this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil diubah', 
            '', 
            false
        );
    }

    public function edit($id)
    {
        $this->updateMode       = true;
        $data = ModelsKategori::where('id', $id)->first();
        $this->dataId           = $id;
        $this->nama_kategori    = $data->nama_kategori;
    }

    public function update()
    {
        $this->validate();

        if( $this->dataId )
        {
            ModelsKategori::findOrFail($this->dataId)->update([
                'nama_kategori'     => $this->nama_kategori
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
        // dd($this->idRemoved);
    }

    public function delete()
    {
        ModelsKategori::findOrFail($this->idRemoved)->delete();
        $this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil dihapus', 
            '', 
            false
        );
    }
}
