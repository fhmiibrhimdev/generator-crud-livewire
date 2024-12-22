<div>
    <section class="section">
        <div class="section-header tw-rounded-none lg:tw-rounded-lg tw-shadow-md tw-shadow-gray-300 px-4">
            <h1 class="tw-text-lg mb-1">Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body px-0">
                    <div class="row tw-px-7">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="name_controller">Nama Controller<br><span
                                        class="tw-text-gray-600 tw-font-normal">Ex:
                                        data-barang.data-barang</span></label>
                                <input type="text" class="form-control tw-rounded-lg" name="name_controller"
                                    id="name_controller" wire:model='name_controller'>
                                @error('name_controller') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="name_model">Nama Model <br><span class="tw-text-gray-600 tw-font-normal">Ex:
                                        DataBarang</span></label>
                                <input type="text" class="form-control tw-rounded-lg" name="name_model" id="name_model"
                                    wire:model='name_model'>
                                @error('name_model') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="timestamps">Timestamps <br><span class="tw-text-gray-600 tw-font-normal">Ex:
                                        Ya</span></label>
                                <select class="form-control tw-rounded-lg" name="timestamps" id="timestamps"
                                    wire:model='timestamps'>
                                    <option value="yes">Ya</option>
                                    <option value="no">Tidak</option>
                                </select>
                                @error('timestamps') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive tw-max-h-96">
                        <table>
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-gray-700">
                                    <th width="22%">Judul <br><span class="tw-text-gray-600 tw-font-normal">Ex: Nama
                                            Lengkap</span></th>
                                    <th width="22%">Nama Data <br><span class="tw-text-gray-600 tw-font-normal">Ex:
                                            nama_lengkap</span></th>
                                    <th width="22%">Element <br><span class="tw-text-gray-600 tw-font-normal">Ex: Input
                                            Text</span></th>
                                    <th width="22%">Validator <br><span class="tw-text-gray-600 tw-font-normal">Ex:
                                            required|max:20|string</span></th>
                                    <th class="text-center">
                                        <i class="fas fa-cog"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $index =>$row)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control tw-rounded-lg" name="judul" id="judul"
                                            wire:model='rows.{{ $index }}.judul'>
                                        @error('judul') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control tw-rounded-lg" name="nama_data"
                                            id="nama_data" wire:model='rows.{{ $index }}.nama_data'>
                                        @error('nama_data') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <select class="form-control tw-rounded-lg" name="element" id="element"
                                            wire:model='rows.{{ $index }}.element'>
                                            <option value="text">Type Text</option>
                                            <option value="number">Type Number</option>
                                            <option value="date">Type Date</option>
                                            <option value="datetime-local">Type DateTime Local</option>
                                            <option value="time">Type Time</option>
                                            <option value="checkbox">Type Checkbox</option>
                                            <option value="file">Type File</option>
                                            <option value="select option">Select Option</option>
                                            <option value="textarea">Textarea</option>
                                        </select>
                                        @error('element') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="text" class="form-control tw-rounded-lg" name="validator"
                                            id="validator" wire:model='rows.{{ $index }}.validator'>
                                        @error('validator') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger" wire:click='removeRow({{ $index }})'>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tw-float-right tw-mr-10">
                        <button class="btn btn-lg btn-outline-primary mt-4" wire:click='addRow'>Add Fields</button>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn-modal" wire:click='generateSyntax()'>
            <i class="far fa-plus"></i>
        </button>

        @if($statusGenerate == "1")
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>Command</b></h4>
                @if($commandSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-bash" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $commandSyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>Routes</b> ==> <span class="tw-select-all">routes\web.php</span>
                </h4>
                @if($routeWebSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $routeWebSyntax }}</code>
                    </pre>
                </div>
                @endif

                <h4 class="tw-text-black tw-text-lg mt-5"><b>Routes</b> ==> <span
                        class="tw-select-all">routes\api.php</span></h4>
                @if($routeApiSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $routeApiSyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>Models</b> ==> <span
                        class="tw-select-all">app\Models\{{ $name_model }}.php</span></h4>
                @if($modelSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $modelSyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>Migrations</b></h4>
                @if($migrationSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $migrationSyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>Seeder</b> ==> <span
                        class="tw-select-all">database\seeders\{{ $name_model }}Seeder.php</span></h4>
                @if($seederSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $seederSyntax }}</code>
                    </pre>
                </div>
                @endif

                <h4 class="tw-text-black tw-text-lg mt-5"><b>DatabaseSeeeder</b> ==> <span
                        class="tw-select-all">database\seeders\DatabaseSeeder.php</span></h4>
                @if($dbSeederSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $dbSeederSyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>Controllers Livewire</b> ==> <span
                        class="tw-select-all">app\Http\Livewire\{{ $nameSpace1 }}\{{ $nameSpace2 }}.php</span></h4>
                @if($controllerLivewireSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $controllerLivewireSyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>Controllers API</b> ==> <span
                        class="tw-select-all">app\Http\Controllers\{{ $nameSpace2 }}Controller.php</span></h4>
                @if($controllerAPISyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-php" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $controllerAPISyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4 class="tw-text-black tw-text-lg"><b>View</b> ==> <span
                        class="tw-select-all">resources\views\livewire\{{ $nameFolder }}\{{ $nameFile }}.blade.php</span>
                </h4>
                @if($viewSyntax == NULL)

                @else
                <div wire:ignore.self>
                    <pre>
                        <code class="language-html" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $viewSyntax }}</code>
                    </pre>
                </div>
                @endif
            </div>
        </div>
        @endif

    </section>
</div>
