<style>
    th:first-child {
        width: 50px;
    }

    table a {
        color: black;
        /* Normal link color */
    }

    table a:visited {
        color: black;
        /* Visited link color */
    }

    table a:hover {
        color: black;
        /* Hover link color */
    }
</style>

<section class="content mt-5">
    <div class="container-fluid">
        <div class="row small-gutter">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?= $kategori->nama_kategori ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sub_categories as $key => $sub_category) : ?>
                                    <tr>
                                        <td><?php echo ($key + 1); ?>.</td>
                                        <td><a href="<?= base_url("kertas/arsip/{$sub_category->id_kategori}/{$sub_category->id}") ?>">
                                                <?= $sub_category->nama_sub_kategori; ?>
                                            </a></td>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>