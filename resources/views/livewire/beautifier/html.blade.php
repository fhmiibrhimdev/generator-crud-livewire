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
                            <h1 class="tw-text-lg mb-3">HTML Beautifier</h1>
                            <textarea id="input" placeholder="Masukkan kode HTML di sini..." class="form-control"
                                style="height: 250px !important"></textarea>
                            <button class="btn btn-primary mt-3" onclick="beautifyCode()">Beautify</button>
                            <div class="mt-3">
                                <h2 class="tw-text-lg">Output</h2>
                                <pre class="mt-3">
                                    <code class="language-html" id="output" data-prismjs-copy="Copy" style="tab-size: 4;"></code>
                                </pre>
                            </div>

                            <script
                                src="https://cdnjs.cloudflare.com/ajax/libs/js-beautify/1.14.0/beautify-html.min.js">
                            </script>
                            <script>
                                function beautifyCode() {
                                    const input = document.getElementById('input').value;
                                    const options = {
                                        indent_size: 4, // ukuran indentasi
                                        indent_char: ' ', // karakter indentasi, bisa berupa ' ' (spasi) atau '\t' (tab)
                                        max_preserve_newlines: 5, // jumlah baris baru berturut-turut yang akan dipertahankan
                                        preserve_newlines: true, // apakah akan mempertahankan baris baru
                                        wrap_line_length: 160, // panjang maksimum baris sebelum dibungkus
                                        end_with_newline: true // tambahkan baris baru di akhir output
                                    };
                                    const output = html_beautify(input, options);
                                    document.getElementById('output').textContent = output;
                                }

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
