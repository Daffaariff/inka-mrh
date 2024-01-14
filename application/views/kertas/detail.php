<div class="container">
    <h2>Detail Dokumen</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-text">Nama File : <b><?= $arsip->nama_file ?></b></h5>
            <p></p>
            <p class="card-text">Nomor Arsip : <b><?= $arsip->no_arsip ?></b></p>
            <p class="card-text">Deskripsi : <b><?= $arsip->deskripsi ?></b></p>
            <p class="card-text">Folder : <b><?= $arsip->nama_kategori ?></b></p>
            <p class="card-text">Sub Folder : <b><?= $arsip->nama_sub_kategori ?></p>
            <!-- Add other details as needed -->

            <!-- Embed the document using an iframe -->
            <iframe src="<?= base_url('/file-arsip/' . $arsip->file_arsip) ?>" style="width: 100%; height: 500px;"></iframe>
        </div>
    </div>
</div>