<div class="container">
    <h2>Add Item</h2>
    <form action="<?= base_url('kertas/add_arsip') ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select class="form-control" id="kategori" name="kategori" required>
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategori_data as $kategori) : ?>
                    <option value="<?= $kategori->id ?>"><?= $kategori->nama_kategori ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="sub_kategori">Sub Kategori</label>
            <select class="form-control" id="sub_kategori" name="sub_kategori" required>
                <option value="">Pilih Sub Kategori</option>
                <!-- Sub kategori akan diisi secara dinamis dengan JavaScript -->
            </select>
        </div>
        <div class="form-group">
            <label for="no_arsip">No Arsip</label>
            <input type="text" class="form-control" id="no_arsip" name="no_arsip" required>
        </div>
        <div class="form-group">
            <label for="nama_file">Nama File</label>
            <input type="text" class="form-control" id="nama_file" name="nama_file" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="file_arsip">File Arsip</label>
            <input type="file" class="form-control-file" id="file_arsip" name="file_arsip" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('arsip'); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Fungsi untuk mengisi pilihan subkategori berdasarkan kategori yang dipilih
        function populateSubKategori() {
            var kategoriId = $("#kategori").val();
            $.ajax({
                url: "<?= base_url('kertas/get_subkategori_by_kategori/') ?>" + kategoriId,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    $("#sub_kategori").html('<option value="">Pilih Sub Kategori</option>');
                    $.each(data, function(key, value) {
                        $("#sub_kategori").append('<option value="' + value.id + '">' + value.nama_sub_kategori + '</option>');
                    });
                }
            });
        }

        // Panggil fungsi populateSubKategori() saat memilih kategori baru
        $("#kategori").change(function() {
            populateSubKategori();
        });

        // Panggil fungsi populateSubKategori() saat halaman pertama kali dimuat
        populateSubKategori();
    });
</script>