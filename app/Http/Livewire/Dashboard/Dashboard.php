<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $rows = [];
    public $parts = [];
    public $name_model, $name_controller, $element, $validator, $timestamps;
    public $modelSyntax, $commandSyntax, $routeWebSyntax, $routeApiSyntax, $migrationSyntax, $controllerLivewireSyntax, $controllerAPISyntax, $viewSyntax, $seederSyntax, $dbSeederSyntax;
    public $nameSpace1, $nameSpace2, $tableName, $nameFolder, $nameFile, $titleView, $count;
    public $statusGenerate;

    public function render()
    {
        if( Auth::user()->hasRole('admin') )
        {
            return view('livewire.dashboard.dashboard-admin')
            ->extends('layouts.apps', ['title' => 'Dashboard']);
        } else if ( Auth::user()->hasRole('user') )
        {
            return view('livewire.dashboard.dashboard-user')
            ->extends('layouts.apps', ['title' => 'Dashboard']);
        } else if ( Auth::user()->hasRole('developer') )
        {
            return view('livewire.dashboard.dashboard-developer')
            ->extends('layouts.apps', ['title' => 'Dashboard']);
        }

    }

    public function mount()
    {
        $this->timestamps = 'yes';
        $this->statusGenerate = 0;
    }

    public function addRow()
    {
        $this->rows[] = [
            'judul'     => '',
            'nama_data' => '',
            'element'   => 'text',
            'validator' => '',
        ];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
    }

    public function generateSyntax()
    {
        $this->statusGenerate = 1;
        
        $nameModel      = $this->name_model; // BarangMasuk
        $nameController = $this->name_controller; // inventory.barang-masuk

        $this->parts = explode(".", $nameController);
        $this->nameSpace1 = str_replace("-", "", ucwords($this->parts[0], "-")); // Inventory
        $this->nameSpace2 = str_replace("-", "", ucwords($this->parts[1], "-")); // BarangMasuk

        $this->tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $nameModel)); // barang_masuk

        $this->nameFolder = $this->parts[0]; // inventory
        $this->nameFile   = $this->parts[1]; // barang-masuk

        $this->titleView  = preg_replace('/(?<=\\w)(?=[A-Z])/', ' ', $this->nameSpace2); // Barang Masuk

        $this->count = count($this->rows) + 2;
        
        $this->generateCommand();
        $this->generateRouteWeb();
        $this->generateRouteApi();
        $this->generateModel();
        $this->generateMigration();
        $this->generateSeeder();
        $this->generateDbSeeder();
        $this->generateControllerLivewire();
        $this->generateControllerAPI();
        $this->generateView();

        $this->alert('success', 'Success', [
            'position'          => 'center',
            'timer'             => '3000',
            'toast'             => false,
            'text'              => 'Code generated successfully',
            'showConfirmButton' => true,
            'onDismissed'       => '',
        ]);
    }

    public function generateCommand()
    {   
        $syntax = '
// Controller Livewire
php artisan make:livewire ' . $this->name_controller . '

// Controller API
php artisan make:controller ' . $this->nameSpace2 . 'Controller --resource

// Model
php artisan make:model ' . $this->name_model. ' -m

// Seeder
php artisan make:seeder ' . $this->nameSpace2 . 'Seeder'
;

        $this->commandSyntax = $syntax;
    }

    public function generateRouteWeb()
    {
        $syntax = "
use App\Http\Livewire\\$this->nameSpace1\\$this->nameSpace2;

Route::get('custom-url', $this->nameSpace2::class)->name('custom-url');";

        $this->routeWebSyntax = $syntax;
    }

    public function generateRouteApi()
    {
        $syntax = "
use App\Http\Controllers\\{$this->nameSpace2}Controller;

Route::resource('custom-url', {$this->nameSpace2}Controller::class);";

        $this->routeApiSyntax = $syntax;
    }

    public function generateModel()
    {
        $syntax = '
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ' . $this->name_model . ' extends Model
{
    use HasFactory;
    protected $table = "' . $this->tableName . '";
    protected $guarded = [];';
if ( $this->timestamps == "no") {
    $syntax .= '
    
    public $timestamps = false;';
}
$syntax .= '
}';

        $this->modelSyntax = $syntax;
    }

    public function generateMigration()
    {
        $syntax = "
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create{$this->name_model}sTable extends Migration
{
    public function up()
    {
        Schema::create('$this->tableName', function (Blueprint \$table) {
            \$table->id();
";
foreach($this->rows as $row) {
    $syntax .= "            \$table->text('$row[nama_data]');\n";
}
if ( $this->timestamps == "yes") {
    $syntax .= "            \$table->timestamps();\n";
}
$syntax .= "        });
    }
    
    public function down()
    {
        Schema::dropIfExists('$this->tableName');
    }
}
";

        $this->migrationSyntax = $syntax;
    }

    public function generateSeeder()
    {
        $syntax =
"
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class {$this->name_model}Seeder extends Seeder
{
    public function run()
    {
        \$data = [";
for ($i=1; $i < 5; $i++) { 
    $syntax .= "\n"."            [\n";
    foreach ($this->rows as $index => $row) {
        if ( $row['element'] == "number" ) {
            $syntax .= "                '" . $row['nama_data'] . "' " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " => '0',\n";
        } else if ( $row['element'] == "date" ) {
            $syntax .= "                '" . $row['nama_data'] . "' " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " => date('Y-m-d'),\n";
        } else {
            $syntax .= "                '" . $row['nama_data'] . "' " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " => '',\n";
        }
    }
    $syntax .= "            ],\n";

}

$syntax .= "        ];

        DB::table('{$this->tableName}')->insert(\$data);
    }
}";
        $this->seederSyntax = $syntax;
    }

    public function generateDbSeeder()
    {
        $syntax =
"
\$this->call([
    ...
    {$this->name_model}Seeder::class
]);";
        $this->dbSeederSyntax = $syntax;
    }

    public function generateControllerLivewire()
    {
        $parts = $this->parts;
        $syntax = 
"
<?php

namespace App\Http\Livewire\\$this->nameSpace1;

use App\Models\\$this->name_model as Models$this->name_model;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class $this->name_model extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected \$listeners = [
        'delete'
    ];

    protected \$rules = [
";
foreach ($this->rows as $index => $row) {
    $syntax .= "        '" . $row['nama_data'] . "' " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " => '$row[validator]',\n";
}
$syntax .= "    ];

    protected \$paginationTheme = 'bootstrap';

    public \$search;
    public \$lengthData  = 10;
    public \$updateMode  = false;
    public \$idRemoved   = NULL;
    public \$dataId      = NULL;

" . implode("\n", array_map(function($row) {
        return "    public $" . str_replace('-', '_', $row['nama_data']) . ";";
    }, $this->rows)) . "

    public function render()
    {
        \$search     = '%'.\$this->search.'%';
        \$lengthData = \$this->lengthData;

        \$data = Models$this->name_model::select('$this->tableName.*')
                ->where(function (\$query) use (\$search) {
"; 
foreach ($this->rows as $index => $row) {
    if( $index == 0 )
    {
        $syntax .= "                    \$query->where('$row[nama_data]', 'LIKE', \$search);\n";
    } else  {
        $syntax .= "                    \$query->orWhere('$row[nama_data]', 'LIKE', \$search);\n";
    }
}
$syntax .= "                })
                ->orderBy('id', 'ASC')
                ->paginate(\$lengthData);

        return view('livewire.$parts[0].$parts[1]', compact('data'))
        ->extends('layouts.apps', ['title' => '$this->titleView']);
    }

    public function mount()
    {
";
foreach ($this->rows as $index => $row) {
    if ( $row['element'] == "date" )
    {
        $syntax .= "        \$this->" . $row['nama_data'] . " " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " = date('Y-m-d');\n";
    } else if ( $row['element'] == "select option" )
    {
        $syntax .= "        \$this->" . $row['nama_data'] . " " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " = 'opsi1';\n";
    } else {
        $syntax .= "        \$this->" . $row['nama_data'] . " " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " = '';\n";
    }
}
$syntax .="    }
    
    private function resetInputFields()
    {
";
foreach ($this->rows as $index => $row) {
    if ( $row['element'] == "date" )
    {
        $syntax .= "        \$this->" . $row['nama_data'] . " " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " = date('Y-m-d');\n";
    } else if ( $row['element'] == "select option" )
    {
        $syntax .= "        \$this->" . $row['nama_data'] . " " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " = 'opsi1';\n";
    } else {
        $syntax .= "        \$this->" . $row['nama_data'] . " " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " = '';\n";
    }
}
$syntax .="    }

    public function cancel()
    {
        \$this->updateMode       = false;
        \$this->resetInputFields();
    }

    private function alertShow(\$type, \$title, \$text, \$onConfirmed, \$showCancelButton)
    {
        \$this->alert(\$type, \$title, [
            'position'          => 'center',
            'timer'             => '3000',
            'toast'             => false,
            'text'              => \$text,
            'showConfirmButton' => true,
            'onConfirmed'       => \$onConfirmed,
            'showCancelButton'  => \$showCancelButton,
            'onDismissed'       => '',
        ]);
        \$this->resetInputFields();
        \$this->emit('dataStore');
    }

    public function store()
    {
        \$this->validate();

        Models$this->name_model::create([
";
foreach ($this->rows as $index => $row) {
    $syntax .= "            '" . $row['nama_data'] . "' " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " => \$this->$row[nama_data],\n";
}
$syntax .= "        ]);

        \$this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil ditambahkan', 
            '', 
            false
        );
    }

    public function edit(\$id)
    {
        \$this->updateMode       = true;
        \$data = Models$this->name_model::where('id', \$id)->first();
        \$this->dataId           = \$id;
";
foreach ($this->rows as $index => $row) {
    $syntax .= "        \$this->$row[nama_data]" . str_repeat(" ", 16 - strlen($row['nama_data'])) . " = \$data->$row[nama_data];\n";
}
$syntax .= "    }

    public function update()
    {
        \$this->validate();

        if( \$this->dataId )
        {
            Models$this->name_model::findOrFail(\$this->dataId)->update([
";
foreach ($this->rows as $index => $row) {
    $syntax .= "                '" . $row['nama_data'] . "' " . str_repeat(" ", 18 - strlen($row['nama_data'])) . " => \$this->$row[nama_data],\n";
}
$syntax .= "            ]);
            \$this->alertShow(
                'success', 
                'Berhasil', 
                'Data berhasil diubah', 
                '', 
                false
            );
        }
    }

    public function deleteConfirm(\$id)
    {
        \$this->idRemoved = \$id;
        \$this->alertShow(
            'warning', 
            'Apa anda yakin?', 
            'Jika anda menghapus data tersebut, data tidak bisa dikembalikan!', 
            'delete', 
            true
        );
    }

    public function delete()
    {
        Models$this->name_model::findOrFail(\$this->idRemoved)->delete();
        \$this->alertShow(
            'success', 
            'Berhasil', 
            'Data berhasil dihapus', 
            '', 
            false
        );
    }
}";

        $this->controllerLivewireSyntax = $syntax;
    }

    public function generateControllerAPI()
    {
        $syntax = 
"
<?php

namespace App\Http\Controllers;

use App\Models\\{$this->name_model} as Models{$this->name_model};
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
        \$data = Models{$this->name_model}::get();

        return response()->json([
            'success'   => true,
            'data'      => \$data,
        ]);
    }

    public function store(Request \$request)
    {
        \$data = Models{$this->name_model}::create(\$request->all());
        if ( \$data )
        {
            \$result = response()->json([
                'success'   => true,
                'data'      => \$data,
                'msg'       => 'Data inserted successfully'
            ]);
        } else {
            \$result = response()->json([
                'success'   => false,
                'msg'       => 'Can't inserted data'
            ], 500);
        }

        return \$result;
    }

    public function edit(\$id)
    {
        \$data = Models{$this->name_model}::where('id', \$id)->first();

        return response()->json([
            'success'   => true,
            'data'      => \$data,
        ]);
    }

    public function update(Request \$request, \$id)
    {
        \$data = Models{$this->name_model}::where('id', \$id)->update(\$request->all());

        if ( \$data )
        {
            \$result = response()->json([
                'success'   => true,
                'msg'       => 'Data updated successfully'
            ]);
        } else {
            \$result = response()->json([
                'success'   => false,
                'msg'       => 'Can't updated data'
            ], 500);
        }

        return \$result;
    }

    public function destroy(\$id)
    {
        \$data = Models{$this->name_model}::where('id', \$id)->delete();

        if ( \$data )
        {
            \$result = response()->json([
                'success'   => true,
                'msg'       => 'Data deleted successfully'
            ]);
        } else {
            \$result = response()->json([
                'success'   => false,
                'msg'       => 'Can't deleted data'
            ], 500);
        }

        return \$result;
    }
}
";
        $this->controllerAPISyntax = $syntax;
    }

    public function generateView()
    {
        $syntax = 
"
<div>
    <section class='section'>
        <div class='section-header tw-rounded-none lg:tw-rounded-lg tw-shadow-md tw-shadow-gray-300 px-4'>
            <h1 class='tw-text-lg mb-1'>$this->titleView</h1>
        </div>

        @if (\$errors->any())
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
                    <h3>Tabel $this->titleView</h3>
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
" . implode("\n", array_map(function($row) {
    return "                                    <th>$row[judul]</th>";
}, $this->rows)) . "
                                    <th class='text-center'>
                                        <i class='fas fa-cog'></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (\$data as \$row)
                                <tr class='text-center'>
                                    <td>{{ \$loop->index + 1 }}</td>
" . implode("\n", array_map(function($row) {
    return "                                    <td class='text-left'>{{ \$row->$row[nama_data] }}</td>";
}, $this->rows)) . "
                                    <td>
                                        <button class='btn btn-warning' wire:click='edit({{ \$row->id }})'
                                            data-toggle='modal' data-target='#ubahDataModal'>
                                            <i class='fas fa-edit'></i>
                                        </button>
                                        <button class='btn btn-danger'
                                            wire:click.prevent='deleteConfirm({{ \$row->id }})'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class='text-center' colspan='$this->count'>No data available in the table</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class='p-3 table-responsive tw-mb-[-15px]'>
                        {{ \$data->links() }}
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
";
foreach ($this->rows as $index => $row) {
    
    if( $row['element'] == "text" || $row['element'] == "number" || $row['element'] == "date" )
    {
        $syntax .= "                        <div class='form-group'>
                            <label for='$row[nama_data]'>$row[judul]</label>
                            <input type='$row[element]' wire:model='$row[nama_data]' id='$row[nama_data]' class='form-control'>
                            @error('$row[nama_data]') <span class='text-danger'>{{ \$message }}</span> @enderror
                        </div>\n";
    } else if ( $row['element'] == "select option" )
    {
        $syntax .= "                        <div class='form-group'>
                            <label for='$row[nama_data]'>$row[judul]</label>
                            <select wire:model='$row[nama_data]' id='$row[nama_data]' class='form-control'>
                                <option value='opsi1'>Opsi 1</option>
                                <option value='opsi2'>Opsi 2</option>
                                <option value='opsi3'>Opsi 3</option>
                            </select>
                            @error('$row[nama_data]') <span class='text-danger'>{{ \$message }}</span> @enderror
                        </div>\n";
    } else if ( $row['element'] == "textarea" )
    {
        $syntax .= "                        <div class='form-group'>
                            <label for='$row[nama_data]'>$row[judul]</label>
                            <textarea wire:model='$row[nama_data]' id='$row[nama_data]' class='form-control' style='height: 100px !important;'></textarea>
                            @error('$row[nama_data]') <span class='text-danger'>{{ \$message }}</span> @enderror
                        </div>\n";
    }
}
$syntax .= "                    </div>
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
";
foreach ($this->rows as $index => $row) {
    
    if( $row['element'] == "text" || $row['element'] == "number" || $row['element'] == "date" )
    {
        $syntax .= "                        <div class='form-group'>
                            <label for='$row[nama_data]'>$row[judul]</label>
                            <input type='$row[element]' wire:model='$row[nama_data]' id='$row[nama_data]' class='form-control'>
                            @error('$row[nama_data]') <span class='text-danger'>{{ \$message }}</span> @enderror
                        </div>\n";
    } else if ( $row['element'] == "select option" )
    {
        $syntax .= "                        <div class='form-group'>
                            <label for='$row[nama_data]'>$row[judul]</label>
                            <select wire:model='$row[nama_data]' id='$row[nama_data]' class='form-control'>
                                <option value='opsi1'>Opsi 1</option>
                                <option value='opsi2'>Opsi 2</option>
                                <option value='opsi3'>Opsi 3</option>
                            </select>
                            @error('$row[nama_data]') <span class='text-danger'>{{ \$message }}</span> @enderror
                        </div>\n";
    } else if ( $row['element'] == "textarea" )
    {
        $syntax .= "                        <div class='form-group'>
                            <label for='$row[nama_data]'>$row[judul]</label>
                            <textarea wire:model='$row[nama_data]' id='$row[nama_data]' class='form-control'></textarea>
                            @error('$row[nama_data]') <span class='text-danger'>{{ \$message }}</span> @enderror
                        </div>\n";
    }
}
$syntax .= "                    </div>
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
";

        $this->viewSyntax = $syntax;
    }

}
