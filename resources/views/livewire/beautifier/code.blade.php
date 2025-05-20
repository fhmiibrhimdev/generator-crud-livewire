<div>
    <section class="section">
        <div class="section-header tw-rounded-none lg:tw-rounded-lg tw-shadow-md tw-shadow-gray-300 px-4">
            <h1 class="tw-text-lg mb-1">Beautifier Code</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body px-4">
                            <div>
                                <textarea wire:model="codeInput" class="form-control" style="height: auto !important;"
                                    rows="10" cols="50" placeholder="Masukkan kode Anda di sini..."></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary mt-3" wire:click="beautify">Rapihkan</button>
                            </div>
                            <div class="mt-3">
                                <h2 class="tw-text-lg">Output</h2>
                                <div wire:ignore.self>
                                    <pre
                                        class="mt-3 language-css"><code class="language-css" id="output" data-prismjs-copy="Copy" style="tab-size: 4;">{{ $codeOutput }}</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
