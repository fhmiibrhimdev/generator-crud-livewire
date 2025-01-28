<?php

namespace App\Http\Livewire\Blog;

use App\Models\Blog as ModelsBlog;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Blog extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete'
    ];

    protected $rules = [
        'tanggal'          => 'required',
        'judul'            => 'required',
        'deskripsi'        => '',
        'status_publish'   => 'required',
    ];

    protected $paginationTheme = 'bootstrap';

    public $search;
    public $lengthData  = 10;
    public $updateMode  = false;
    public $idRemoved   = NULL;
    public $dataId      = NULL;

    public $tanggal;
    public $judul;
    public $deskripsi;
    public $status_publish;

    public function render()
    {
        $search     = '%' . $this->search . '%';
        $lengthData = $this->lengthData;

        $data = ModelsBlog::where(function ($query) use ($search) {
            $query->where('tanggal', 'LIKE', $search);
            $query->orWhere('judul', 'LIKE', $search);
            $query->orWhere('deskripsi', 'LIKE', $search);
            $query->orWhere('status_publish', 'LIKE', $search);
        })
            ->orderBy('id', 'ASC')
            ->paginate($lengthData);

        return view('livewire.blog.blog', compact('data'))
            ->extends('layouts.apps', ['title' => 'Blog']);
    }

    public function mount()
    {
        $this->tanggal          = '';
        $this->judul            = '';
        $this->deskripsi        = '';
        $this->status_publish   = '';
    }

    private function resetInputFields()
    {
        $this->tanggal          = '';
        $this->judul            = '';
        $this->deskripsi        = '';
        $this->status_publish   = '';
    }

    public function cancel()
    {
        $this->updateMode       = false;
        $this->resetInputFields();
    }

    private function alertShow($type, $title, $text, $onConfirmed, $showCancelButton)
    {
        $this->alert($type, $title, [
            'position'  => 'center',
            'timer'     => '3000',
            'toast'        => false,
            'text' => $text,
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

        ModelsBlog::create([
            'tanggal'          => $this->tanggal,
            'judul'            => $this->judul,
            'deskripsi'        => $this->deskripsi,
            'status_publish'   => $this->status_publish,
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
        $data = ModelsBlog::where('id', $id)->first();
        $this->dataId           = $id;
        $this->tanggal         = $data->tanggal;
        $this->judul           = $data->judul;
        $this->deskripsi       = $data->deskripsi;
        $this->status_publish  = $data->status_publish;
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            ModelsBlog::findOrFail($this->dataId)->update([
                'tanggal'          => $this->tanggal,
                'judul'            => $this->judul,
                'deskripsi'        => $this->deskripsi,
                'status_publish'   => $this->status_publish,
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
        ModelsBlog::findOrFail($this->idRemoved)->delete();
        $this->alertShow(
            'success',
            'Berhasil',
            'Data berhasil dihapus',
            '',
            false
        );
    }
}
