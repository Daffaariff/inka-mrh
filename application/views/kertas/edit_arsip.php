<!-- update_item_page.php -->
<div class="container">
    <h2>Edit Arsip</h2>
    <form action="<?= base_url('kertas/edit_arsip/' . $arsip->id) ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="no_arsip">No Arsip</label>
            <input type="text" class="form-control" id="no_arsip" name="no_arsip" value="<?= $arsip->no_arsip ?>" required>
        </div>
        <div class="form-group">
            <label for="nama_file">Nama File</label>
            <input type="text" class="form-control" id="nama_file" name="nama_file" value="<?= $arsip->nama_file ?>" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= $arsip->deskripsi ?></textarea>
        </div>
        <div class="form-group">
            <label for="file_arsip">File Arsip</label>
            <input type="file" class="form-control-file" id="file_arsip" name="file_arsip">
            <small class="form-text text-muted">Pilih file baru jika ingin mengganti file arsip.</small>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('kertas/arsip/' . $arsip->id_kategori . '/' . $arsip->id_sub_kategori) ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>