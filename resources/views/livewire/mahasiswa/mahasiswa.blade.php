<div>
    <section class='section'>
        <div class='section-header tw-rounded-none lg:tw-rounded-lg tw-shadow-md tw-shadow-gray-300 px-4'>
            <h1 class='tw-text-lg mb-1'>Mahasiswa</h1>
        </div>

        @if ($errors->any())
        <script>
            Swal.fire(
                'error',
                'Ada yang error',
                'error'
            )
        </script>
        @endif

        <div class='section-body'>
            <div class='card'>
                <div class='card-body px-0'>
                    <h3>Tabel Mahasiswa</h3>
                    <div class='show-entries'>
                        <p class='show-entries-show'>Show</p>
                        <select wire:model='lengthData' id='length-data'>
                            <option value='1'>1</option>
                            <option value='5'>5</option>
                            <option value='10'>10</option>
                            <option value='25'>25</option>
                            <option value='50'>50</option>
                            <option value='100'>100</option>
                        </select>
                        <p class='show-entries-entries'>Entries</p>
                    </div>
                    <div class='search-column'>
                        <p>Search: </p>
                        <input type='search' wire:model.debounce.750ms='search' id='search-data' placeholder='Search here...'>
                    </div>
                    <div class='table-responsive tw-max-h-96'>
                        <table>
                            <thead class='tw-sticky tw-top-0'>
                                <tr class='tw-text-gray-700'>
                                    <th width='15%' class='text-center'>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIM</th>
                                    <th>Deskripsi</th>
                                    <th class='text-center'>
                                        <i class='fas fa-cog'></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                <tr class='text-center'>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class='text-left'>{{ $row->nama_lengkap }}</td>
                                    <td class='text-left'>{{ $row->nim }}</td>
                                    <td class='text-left'>{{ $row->deskripsi }}</td>
                                    <td>
                                        <button class='btn btn-warning' wire:click='edit({{ $row->id }})'
                                            data-toggle='modal' data-target='#ubahDataModal'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <button class='btn btn-danger'
                                            wire:click.prevent='deleteConfirm({{ $row->id }})'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class='text-center' colspan='5'>No data available in the table</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class='p-3 table-responsive tw-mb-[-15px]'>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
        <button class='btn-modal' data-toggle='modal' data-target='#tambahDataModal'>
            <i class='far fa-plus'></i>
        </button>
    </section>

    <div class='modal fade' wire:ignore.self id='tambahDataModal' aria-labelledby='tambahDataModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='tambahDataModalLabel'>Tambah Data</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <form>
                    <div class='modal-body'>
                        <div class='form-group'>
                            <label for='nama_lengkap'>Nama Lengkap</label>
                            <input type='text' wire:model='nama_lengkap' id='nama_lengkap' class='form-control'>
                            @error('nama_lengkap') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>
                        <div class='form-group'>
                            <label for='nim'>NIM</label>
                            <input type='number' wire:model='nim' id='nim' class='form-control'>
                            @error('nim') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>
                        <div class='form-group'>
                            <label for='deskripsi'>Deskripsi</label>
                            <textarea wire:model='deskripsi' id='deskripsi' class='form-control' style='height: 100px !important;'></textarea>
                            @error('deskripsi') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary tw-bg-gray-300'
                            data-dismiss='modal'>Close</button>
                        <button type='submit' wire:click.prevent='store()' wire:loading.attr='disabled'
                            class='btn btn-primary tw-bg-blue-500'>Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class='modal fade' wire:ignore.self id='ubahDataModal' aria-labelledby='ubahDataModalLabel' aria-hidden='true'
        data-keyboard='false' data-backdrop='static'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='ubahDataModalLabel'>Edit Data</h5>
                    <button type='button' wire:click.prevent='cancel()' class='close' data-dismiss='modal'
                        aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <form>
                    <div class='modal-body'>
                        <input type='hidden' wire:model='dataId'>
                        <div class='form-group'>
                            <label for='nama_lengkap'>Nama Lengkap</label>
                            <input type='text' wire:model='nama_lengkap' id='nama_lengkap' class='form-control'>
                            @error('nama_lengkap') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>
                        <div class='form-group'>
                            <label for='nim'>NIM</label>
                            <input type='number' wire:model='nim' id='nim' class='form-control'>
                            @error('nim') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>
                        <div class='form-group'>
                            <label for='deskripsi'>Deskripsi</label>
                            <textarea wire:model='deskripsi' id='deskripsi' class='form-control'></textarea>
                            @error('deskripsi') <span class='text-danger'>{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary tw-bg-gray-300'
                            data-dismiss='modal'>Close</button>
                        <button type='submit' wire:click.prevent='update()' wire:loading.attr='disabled'
                            class='btn btn-primary tw-bg-blue-500'>Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>