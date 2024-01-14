<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="col-md-6">
                                <h3 class="card-title">Arsip</h3>
                            </div>
                            <div class="col-md-6 text-right">
                                <!-- Add item button -->
                                <button type="button" class="btn btn-primary" onclick="redirectToAddArsip()">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if (empty($arsip_data)) : ?>
                                <p>No arsip found.</p>
                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Arsip</th>
                                                <th>Nama File</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal Upload</th>
                                                <th>Tanggal Update</th>
                                                <th>File Arsip</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($arsip_data as $key => $arsip) : ?>
                                                <tr>
                                                    <td><?= ($key + 1); ?></td>
                                                    <td><?= $arsip->no_arsip; ?></td>
                                                    <td><?= $arsip->nama_file; ?></td>
                                                    <td><?= $arsip->deskripsi; ?></td>
                                                    <td><?= $arsip->tgl_upload; ?></td>
                                                    <td><?= $arsip->tgl_update; ?></td>
                                                    <td class="text-center"> <a href="<?= base_url('kertas/detail/' . $arsip->id); ?>"><i class="bi bi-file-earmark-pdf"><img src="<?= base_url("assets/images/file-pdf.svg") ?>"></i></a></td>
                                                    <td>
                                                        <a href=" <?= base_url("kertas/edit_arsip/{$arsip->id}") ?>" class="btn btn-sm btn-info">Edit</a>
                                                        <a href="<?= base_url("kertas/delete_arsip/{$arsip->id}") ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus arsip ini?')">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function redirectToAddArsip() {
        // Redirect to the add_arsip page when the "Add Item" button is clicked
        window.location.href = '<?= base_url("kertas/add_arsip") ?>';
    }
</script>